<?php

namespace Marketcall;

use Marketcall\Common\Exceptions\ApiException;
use Marketcall\Models\Paginator;

abstract class AbstractClient
{
    protected ?string $requestId = null;

    public function getLastRequestId(): ?string
    {
        return $this->requestId;
    }

    /**
     * @template T
     * @param array $response
     * @param class-string<T> $modelClass
     * @return array{data: T[], paginator: ?Paginator}
     * @throws ApiException
     */
    protected function parseListResponse(array $response, string $modelClass): array
    {
        $this->saveRequestId($response);

        $data = array_map(fn(array $item) => $modelClass::fromArray($item), $response['data'] ?? []);

        $paginator = isset($response['paginator']) ? Paginator::fromArray($response['paginator']) : null;

        return [
            'data' => $data,
            'paginator' => $paginator,
        ];
    }

    /**
     * @template T
     * @param array $response
     * @param class-string<T> $modelClass
     * @return T
     */
    protected function parseResponse(array $response, string $modelClass)
    {
        $this->saveRequestId($response);
        return $modelClass::fromArray($response['data'] ?? []);
    }

    /**
     * @param array $response
     * @return void
     */
    private function saveRequestId(array $response): void
    {
        $this->requestId = $response['request_id'] ?? null;
    }
}
