<?php

declare(strict_types=1);

namespace Marketcall\Transport;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use Marketcall\Common\Exceptions\ApiException;
use Marketcall\Common\Exceptions\BadRequestException;
use Marketcall\Common\Exceptions\ForbiddenException;
use Marketcall\Common\Exceptions\NotFoundException;
use Marketcall\Common\Exceptions\TooManyRequestsException;
use Marketcall\Common\Exceptions\UnauthorizedException;
use Psr\Http\Message\ResponseInterface;

class HttpClient
{
    private GuzzleClient $client;
    private string $apiKey;
    private array $rateLimitInfo = [];

    public function __construct(
        string $baseUrl,
        string $apiKey,
    )
    {
        $this->apiKey = $apiKey;

        $this->client = new GuzzleClient([
            'base_uri' => $baseUrl,
            'timeout' => 30,
            'http_errors' => false,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'User-Agent' => 'Marketcall-PHP-SDK/1.0',
            ],
        ]);
    }

    /**
     * @param string $path
     * @param array $params
     * @return array
     * @throws ApiException
     */
    public function get(string $path, array $params = []): array
    {
        return $this->request('GET', $path, ['query' => $params]);
    }

    /**
     * @param string $path
     * @param array $data
     * @return array
     * @throws ApiException
     */
    public function post(string $path, array $data = []): array
    {
        return $this->request('POST', $path, ['json' => $data]);
    }

    /**
     * @param string $path
     * @param array $data
     * @return array
     * @throws ApiException
     */
    public function put(string $path, array $data = []): array
    {
        return $this->request('PUT', $path, ['json' => $data]);
    }

    /**
     * @param string $path
     * @return array
     * @throws ApiException
     */
    public function delete(string $path): array
    {
        return $this->request('DELETE', $path);
    }

    /**
     * @param string $method
     * @param string $path
     * @param array $options
     * @return array
     * @throws ApiException
     * @throws \Exception
     */
    private function request(string $method, string $path, array $options = []): array
    {
        // Добавляем API ключ в заголовок
        $options['headers']['X-Api-Key'] = $this->apiKey;

        try {
            $response = $this->client->request($method, $path, $options);

            $this->processRateLimitHeaders($response);

            $statusCode = $response->getStatusCode();

            if ($statusCode >= 200 && $statusCode < 300) {
                return $this->parseResponse($response);
            }

            $this->handleErrorResponse($response);
        } catch (ClientException|ServerException $e) {
            $this->handleGuzzleException($e);
        } catch (GuzzleException $e) {
            throw new ApiException(
                'Request failed: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
        throw new \Exception('Request failed');
    }

    private function processRateLimitHeaders(ResponseInterface $response): void
    {
        $headers = $response->getHeaders();

        $this->rateLimitInfo = [
            'limit' => $headers['X-RateLimit-Limit'][0] ?? null,
            'remaining' => $headers['X-RateLimit-Remaining'][0] ?? null,
            'reset' => $headers['X-RateLimit-Reset'][0] ?? null,
        ];

        if ($response->hasHeader('Retry-After')) {
            $this->rateLimitInfo['retry_after'] = $response->getHeaderLine('Retry-After');
        }
    }

    public function getRateLimitInfo(): array
    {
        return $this->rateLimitInfo;
    }

    private function parseResponse(ResponseInterface $response): array
    {
        $body = (string)$response->getBody();

        $data = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ApiException(
                'Failed to parse response: ' . json_last_error_msg()
            );
        }

        return $data;
    }

    /**
     * @throws UnauthorizedException
     * @throws ForbiddenException
     * @throws NotFoundException
     * @throws BadRequestException
     * @throws TooManyRequestsException
     * @throws ApiException
     */
    private function handleErrorResponse(ResponseInterface $response): void
    {
        $statusCode = $response->getStatusCode();
        $body = (string)$response->getBody();
        $data = json_decode($body, true);

        $message = $data['error']['message'] ?? 'Unknown error';

        match (true) {
            $statusCode === 400, $statusCode === 422 => throw new BadRequestException($message, $statusCode),
            $statusCode === 401 => throw new UnauthorizedException($message, $statusCode),
            $statusCode === 403 => throw new ForbiddenException($message, $statusCode),
            $statusCode === 404 => throw new NotFoundException($message, $statusCode),
            $statusCode === 429 => throw new TooManyRequestsException(
                $message,
                $statusCode,
                $this->rateLimitInfo['retry_after'] ?? null
            ),
            default => throw new ApiException($message, $statusCode),
        };
    }

    private function handleGuzzleException(ClientException|ServerException $e): void
    {
        $response = $e->getResponse();

        $this->handleErrorResponse($response);
    }
}
