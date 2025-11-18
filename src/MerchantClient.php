<?php

declare(strict_types=1);

namespace Marketcall;

use Marketcall\Common\Exceptions\ApiException;
use Marketcall\Models\Merchant\Account;
use Marketcall\Models\Merchant\BrokerLead;
use Marketcall\Models\Merchant\Call;
use Marketcall\Models\Merchant\Lead;
use Marketcall\Models\Merchant\Offer;
use Marketcall\Requests\Affiliate\CommentCallRequest;
use Marketcall\Requests\Affiliate\RefuseCallRequest;
use Marketcall\Requests\Merchant\AddBrokerLeadRequest;
use Marketcall\Requests\Merchant\CostLeadRequest;
use Marketcall\Requests\Merchant\LeadsRequest;
use Marketcall\Requests\Merchant\CallsRequest;
use Marketcall\Requests\Merchant\OffersRequest;
use Marketcall\Requests\Merchant\RefuseLeadRequest;
use Marketcall\Transport\HttpClient;

class MerchantClient extends AbstractClient
{
    private const API_BASE_URL = 'https://www.marketcall.ru/api/v1/merchant/';

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
     * Получить информацию о звонке
     * @throws ApiException
     * @throws \Exception
     */
    public function getCall(int $callId): Call
    {
        $response = $this->httpClient->get("calls/{$callId}");
        return $this->parseResponse($response, Call::class);
    }

    /**
     * Подтвердить звонок
     * @throws ApiException
     * @throws \Exception
     */
    public function approveCall(int $callId): Call
    {
        $response = $this->httpClient->post("calls/{$callId}/approve");
        return $this->parseResponse($response, Call::class);
    }

    /**
     * Отклонить звонок
     * @throws ApiException
     * @throws \Exception
     */
    public function refuseCall(int $callId, RefuseCallRequest $request): Call
    {
        $response = $this->httpClient->post("calls/{$callId}/refuse", $request->toArray());
        return $this->parseResponse($response, Call::class);
    }

    /**
     * Добавить комментарий к звонку
     * @throws ApiException
     * @throws \Exception
     */
    public function commentCall(int $callId, CommentCallRequest $request): Call
    {
        $response = $this->httpClient->post("calls/{$callId}/comment", $request->toArray());
        return $this->parseResponse($response, Call::class);
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
     * Получить информацию об оффере
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
     * Получить список лидов
     * @throws ApiException
     */
    public function getLeads(?LeadsRequest $request = null): array
    {
        $params = $request?->toArray() ?? [];
        $response = $this->httpClient->get('leads', $params);
        return $this->parseListResponse($response, Lead::class);
    }

    /**
     * Получить информацию о лиде
     * @throws ApiException
     * @throws \Exception
     */
    public function getLead(int $leadId): Lead
    {
        $response = $this->httpClient->get("leads/{$leadId}");
        return $this->parseResponse($response, Lead::class);
    }

    /**
     * Подтвердить лид
     * @throws ApiException
     * @throws \Exception
     */
    public function approveLead(int $leadId): Lead
    {
        $response = $this->httpClient->post("leads/{$leadId}/approve");
        return $this->parseResponse($response, Lead::class);
    }

    /**
     * Перевести лид в HOLD
     * @throws ApiException
     * @throws \Exception
     */
    public function holdLead(int $leadId): Lead
    {
        $response = $this->httpClient->post("leads/{$leadId}/hold");
        return $this->parseResponse($response, Lead::class);
    }

    /**
     * Отклонить лид
     * @throws ApiException
     * @throws \Exception
     */
    public function refuseLead(int $leadId, RefuseLeadRequest $request): Lead
    {
        $response = $this->httpClient->post("leads/{$leadId}/refuse", $request->toArray());
        return $this->parseResponse($response, Lead::class);
    }

    /**
     * Изменить ценность лида
     * @throws ApiException
     * @throws \Exception
     */
    public function setLeadCost(int $leadId, CostLeadRequest $request): Lead
    {
        $response = $this->httpClient->post("leads/{$leadId}/cost", $request->toArray());
        return $this->parseResponse($response, Lead::class);
    }

    /**
     * Добавить лид для брокера
     * @throws ApiException
     */
    public function addBrokerLead(AddBrokerLeadRequest $request): BrokerLead
    {
        $params = $request->toArray();
        $response = $this->httpClient->post('broker/leads', $params);
        return $this->parseResponse($response, BrokerLead::class);
    }

    /**
     * Получить список счетов рекламодателя
     * @return array
     * @throws ApiException
     */
    public function getAccounts(): array
    {
        $response = $this->httpClient->get('accounts');
        return $this->parseListResponse($response, Account::class);
    }
}
