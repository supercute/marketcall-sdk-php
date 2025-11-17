<?php

declare(strict_types=1);

namespace Marketcall;

use Marketcall\Common\Exceptions\ApiException;
use Marketcall\Model\Account;
use Marketcall\Model\BrokerLead;
use Marketcall\Model\Call;
use Marketcall\Model\Lead;
use Marketcall\Model\Offer;
use Marketcall\Model\Paginator;
use Marketcall\Request\Broker\AddBrokerLeadRequest;
use Marketcall\Request\Calls\CallsRequest;
use Marketcall\Request\Calls\CommentCallRequest;
use Marketcall\Request\Calls\RefuseCallRequest;
use Marketcall\Request\Leads\CostLeadRequest;
use Marketcall\Request\Leads\CreateLeadRequest;
use Marketcall\Request\Leads\LeadsRequest;
use Marketcall\Request\Leads\RefuseLeadRequest;
use Marketcall\Request\Offers\OffersRequest;
use Marketcall\Transport\HttpClient;

class Client
{
    private const API_BASE_URL = 'https://www.marketcall.ru/api/v1/merchant/';

    private HttpClient $httpClient;
    private string $apiKey;
    private ?string $requestId = null;

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
     * Список звонков
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
     * Информация о звонке
     * @throws ApiException
     * @throws \Exception
     */
    public function getCall(int $callId): Call
    {
        $response = $this->httpClient->get("calls/{$callId}");
        return Call::fromArray($response['data']);
    }

    /**
     * Подтверждение звонка
     * @throws ApiException
     * @throws \Exception
     */
    public function approveCall(int $callId): Call
    {
        $response = $this->httpClient->post("calls/{$callId}/approve");
        return Call::fromArray($response['data']);
    }

    /**
     * Отклонение звонка
     * @throws ApiException
     * @throws \Exception
     */
    public function refuseCall(int $callId, RefuseCallRequest $request): Call
    {
        $response = $this->httpClient->post("calls/{$callId}/refuse", $request->toArray());
        return Call::fromArray($response['data']);
    }

    /**
     * Комментирование звонка
     * @throws ApiException
     * @throws \Exception
     */
    public function commentCall(int $callId, CommentCallRequest $request): Call
    {
        $response = $this->httpClient->post("calls/{$callId}/comment", $request->toArray());
        return Call::fromArray($response['data']);
    }


    /**
     * Список офферов
     * @throws ApiException
     */
    public function getOffers(?OffersRequest $request = null): array
    {
        $params = $request?->toArray() ?? [];
        $response = $this->httpClient->get('offers', $params);
        return $this->parseListResponse($response, Offer::class);
    }

    /**
     * Информация об оффере
     * @param int $offerId
     * @return Offer
     * @throws ApiException
     */
    public function getOffer(int $offerId): Offer
    {
        $response = $this->httpClient->get("offers/{$offerId}");
        return Offer::fromArray($response['data']);
    }

    /**
     * @throws ApiException
     */
    public function getLeads(?LeadsRequest $request = null): array
    {
        $params = $request?->toArray() ?? [];
        $response = $this->httpClient->get('leads', $params);
        return $this->parseListResponse($response, Lead::class);
    }

    /**
     * Список лидов
     * @throws ApiException
     * @throws \Exception
     */
    public function getLead(int $leadId): Lead
    {
        $response = $this->httpClient->get("leads/{$leadId}");
        return Lead::fromArray($response['data']);
    }

    /**
     * Информация о лиде
     * @throws ApiException
     * @throws \Exception
     */
    public function createLead(CreateLeadRequest $request): Lead
    {
        $response = $this->httpClient->post('leads', $request->toArray());
        return Lead::fromArray($response['data']);
    }

    /**
     * Подтверждение лида
     * @throws ApiException
     * @throws \Exception
     */
    public function approveLead(int $leadId): Lead
    {
        $response = $this->httpClient->post("leads/{$leadId}/approve");
        return Lead::fromArray($response['data']);
    }

    /**
     * Перевод лида в HOLD
     * @throws ApiException
     * @throws \Exception
     */
    public function holdLead(int $leadId): Lead
    {
        $response = $this->httpClient->post("leads/{$leadId}/hold");
        return Lead::fromArray($response['data']);
    }

    /**
     * Отклонение лида
     * @throws ApiException
     * @throws \Exception
     */
    public function refuseLead(int $leadId, RefuseLeadRequest $request): Lead
    {
        $response = $this->httpClient->post("leads/{$leadId}/refuse", $request->toArray());
        return Lead::fromArray($response['data']);
    }

    /**
     * Изменение ценности лида
     * @throws ApiException
     * @throws \Exception
     */
    public function setLeadCost(int $leadId, CostLeadRequest $request): Lead
    {
        $response = $this->httpClient->post("leads/{$leadId}/cost", $request->toArray());
        return Lead::fromArray($response['data']);
    }

    /**
     * Добавление лида для брокера
     * @throws ApiException
     */
    public function addBrokerLead(AddBrokerLeadRequest $request): array
    {
        $params = $request->toArray();
        $response = $this->httpClient->post('broker/leads', $params);

        $this->requestId = $response['request_id'] ?? null;

        $data = $response['data'] ?? [];

        return array_map(fn(array $item) => BrokerLead::fromArray($item), is_array($data) ? $data : []);
    }

    /**
     * Список счетов рекламодателя
     * @return array
     * @throws ApiException
     */
    public function getAccounts(): array
    {
        $response = $this->httpClient->get('accounts');
        return $this->parseListResponse($response, Account::class);
    }

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
        $this->requestId = $response['request_id'] ?? null;

        $data = array_map(fn(array $item) => $modelClass::fromArray($item), $response['data'] ?? []);

        $paginator = isset($response['paginator']) ? Paginator::fromArray($response['paginator']) : null;

        return [
            'data' => $data,
            'paginator' => $paginator,
        ];
    }
}
