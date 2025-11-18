<?php

declare(strict_types=1);

namespace Marketcall;

use Marketcall\Common\Exceptions\ApiException;
use Marketcall\Models\Affiliate\Call;
use Marketcall\Models\Affiliate\CallCount;
use Marketcall\Models\Affiliate\Category;
use Marketcall\Models\Affiliate\Channel;
use Marketcall\Models\Affiliate\IncomingCallAbility;
use Marketcall\Models\Affiliate\Lead;
use Marketcall\Models\Affiliate\Offer;
use Marketcall\Models\Affiliate\Phone;
use Marketcall\Models\Affiliate\Program;
use Marketcall\Models\Affiliate\Region;
use Marketcall\Models\BinaryFile;
use Marketcall\Models\Success;
use Marketcall\Requests\Affiliate\CallsCountRequest;
use Marketcall\Requests\Affiliate\CallsRequest;
use Marketcall\Requests\Affiliate\ChannelsRequest;
use Marketcall\Requests\Affiliate\CreateProgramRequest;
use Marketcall\Requests\Affiliate\LeadsRequest;
use Marketcall\Requests\Affiliate\OffersRequest;
use Marketcall\Requests\Affiliate\ProgramsRequest;
use Marketcall\Transport\HttpClient;

class AffiliateClient extends AbstractClient
{
    private const API_BASE_URL = 'https://www.marketcall.ru/api/v1/affiliate/';

    private HttpClient $httpClient;
    private string $apiKey;

    public function __construct(
        string $apiKey,
    )
    {
        $this->apiKey = $apiKey;
        $this->httpClient = new HttpClient(
            self::API_BASE_URL,
            $this->apiKey,
        );
    }

    /**
     * Получить список звонков
     * @param CallsRequest|null $request
     * @return array
     * @throws ApiException
     */
    public function getCalls(?CallsRequest $request = null): array
    {
        $params = $request?->toArray() ?? [];
        $response = $this->httpClient->get('calls', $params);
        return $this->parseListResponse($response, Call::class);
    }

    /**
     * Получить количество звонков
     * @throws ApiException
     * @throws \Exception
     */
    public function getCallsCount(?CallsCountRequest $request = null): CallCount
    {
        $params = $request?->toArray() ?? [];
        $response = $this->httpClient->get('calls/count', $params);
        return $this->parseResponse($response, CallCount::class);
    }


    /**
     * Получить аудиозапись звонка
     *
     * @param int $callId
     * @return BinaryFile
     * @throws ApiException
     */
    public function getCallRecord(int $callId): BinaryFile
    {
        $response = $this->httpClient->getBinary("calls/{$callId}/record");

        $this->requestId = $response['request_id'] ?? null;

        return BinaryFile::fromResponse(
            content: $response['body'],
            headers: $response['headers']
        );
    }

    /**
     * Получить список номеров
     * @throws ApiException
     */
    public function getPhones(bool $without_programs = false): array
    {
        $params = [];
        if ($without_programs) {
            $params['without_programs'] = 1;
        }
        $response = $this->httpClient->get('phones', $params);
        return $this->parseListResponse($response, Phone::class);
    }

    /**
     * Получить список регионов
     * @throws ApiException
     */
    public function getRegions(): array
    {
        $response = $this->httpClient->get('regions');
        return $this->parseListResponse($response, Region::class);
    }

    /**
     * Получить список категорий
     * @throws ApiException
     */
    public function getCategories(): array
    {
        $response = $this->httpClient->get('categories');
        var_dump($response);
        return $this->parseListResponse($response, Category::class);
    }

    /**
     * Получить список офферов
     * @throws ApiException
     */
    public function getOffers(?OffersRequest $request = null): array
    {
        $params = $request?->toArray() ?? [];
        $response = $this->httpClient->get('offers', $params);
        return $this->parseListResponse($response, Offer::class);
    }

    /**
     * Получить оффер
     * @param int $offerId
     * @return Offer
     * @throws ApiException
     */
    public function getOffer(int $offerId): Offer
    {
        $response = $this->httpClient->get("offers/{$offerId}");
        return $this->parseResponse($response, Offer::class);
    }

    /**
     * Проверить возможность совершить входящий звонок на оффер
     * @throws ApiException
     */
    public function getIncomingCallAbility(int $offerId): IncomingCallAbility
    {
        $response = $this->httpClient->get("offers/{$offerId}/incoming-call-ability");
        return $this->parseResponse($response, IncomingCallAbility::class);
    }

    /**
     * Получить список программ
     * @throws ApiException
     */
    public function getPrograms(ProgramsRequest $request): array
    {
        $params = $request?->toArray() ?? [];
        $response = $this->httpClient->get('programs', $params);
        return $this->parseListResponse($response, Program::class);
    }

    /**
     * Получить программу
     * @param int $programId
     * @return Program
     * @throws ApiException
     */
    public function getProgram(int $programId): Program
    {
        $response = $this->httpClient->get("programs/{$programId}");
        return $this->parseResponse($response, Program::class);
    }

    /**
     * Создать программу
     * @throws ApiException
     */
    public function createProgram(CreateProgramRequest $request): Program
    {
        $params = $request?->toArray() ?? [];
        $response = $this->httpClient->post('programs', $params);
        return $this->parseResponse($response, Program::class);
    }

    public function cancelProgram(int $programId): Success
    {
        $response = $this->httpClient->post("programs/{$programId}/cancel");
        return $this->parseResponse($response, Success::class);
    }

    /**
     * Получить список лидов
     * @param LeadsRequest|null $request
     * @return array
     * @throws ApiException
     */
    public function getLeads(?LeadsRequest $request = null): array
    {
        $params = $request?->toArray() ?? [];
        $response = $this->httpClient->get('leads', $params);
        return $this->parseListResponse($response, Lead::class);
    }

    /**
     * Получить лид
     * @param int $leadId
     * @return Lead
     * @throws ApiException
     */
    public function getLead(int $leadId): Lead
    {
        $response = $this->httpClient->get("leads/{$leadId}");
        return $this->parseResponse($response, Lead::class);
    }

    /**
     * Получить список каналов
     * @throws ApiException
     */
    public function getChannels(?ChannelsRequest $request = null): array
    {
        $params = $request?->toArray() ?? [];
        $response = $this->httpClient->get('channels', $params);
        return $this->parseListResponse($response, Channel::class);
    }

    /**
     * Получить канал
     * @param int $channelId
     * @return Channel
     * @throws ApiException
     */
    public function getChannel(int $channelId): Channel
    {
        $response = $this->httpClient->get("channels/{$channelId}");
        return $this->parseResponse($response, Channel::class);
    }

    /**
     * Создать канал
     * @param string $title
     * @return Channel
     * @throws ApiException
     */
    public function createChannel(string $title): Channel
    {
        $response = $this->httpClient->post('channels', ['title' => $title]);
        return $this->parseResponse($response, Channel::class);
    }

}
