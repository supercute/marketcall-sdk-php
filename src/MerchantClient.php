<?php

declare(strict_types=1);

namespace Marketcall;

use Marketcall\Common\Exceptions\ApiException;
use Marketcall\Models\ListResponse;
use Marketcall\Models\Merchant\Account;
use Marketcall\Models\Merchant\BrokerLead;
use Marketcall\Models\Merchant\Call;
use Marketcall\Models\Merchant\Lead;
use Marketcall\Models\Merchant\Offer;
use Marketcall\Requests\Affiliate\CommentCallRequest;
use Marketcall\Requests\Affiliate\RefuseCallRequest;
use Marketcall\Requests\Merchant\AddBrokerLeadRequest;
use Marketcall\Requests\Merchant\CallsRequest;
use Marketcall\Requests\Merchant\CostLeadRequest;
use Marketcall\Requests\Merchant\LeadsRequest;
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
     * @return ListResponse
     * @throws ApiException
     */
    public function getCalls(?CallsRequest $request = null): ListResponse
    {
        $params = $request?->toArray() ?? [];
        $response = $this->httpClient->get('calls', $params);
        return $this->parseListResponse($response, Call::class);
    }


    /**
     * Получить информацию о звонке
     * @param int $callId
     * @return Call
     * @throws ApiException
     */
    public function getCall(int $callId): Call
    {
        $response = $this->httpClient->get("calls/{$callId}");
        return $this->parseResponse($response, Call::class);
    }

    /**
     * Подтвердить звонок
     * @param int $callId
     * @return Call
     * @throws ApiException
     */
    public function approveCall(int $callId): Call
    {
        $response = $this->httpClient->post("calls/{$callId}/approve");
        return $this->parseResponse($response, Call::class);
    }

    /**
     * Отклонить звонок
     * @param int $callId
     * @param RefuseCallRequest $request
     * @return Call
     * @throws ApiException
     */
    public function refuseCall(int $callId, RefuseCallRequest $request): Call
    {
        $response = $this->httpClient->post("calls/{$callId}/refuse", $request->toArray());
        return $this->parseResponse($response, Call::class);
    }

    /**
     * Добавить комментарий к звонку
     * @param int $callId
     * @param CommentCallRequest $request
     * @return Call
     * @throws ApiException
     */
    public function commentCall(int $callId, CommentCallRequest $request): Call
    {
        $response = $this->httpClient->post("calls/{$callId}/comment", $request->toArray());
        return $this->parseResponse($response, Call::class);
    }


    /**
     * Получить список офферов
     * @param OffersRequest|null $request
     * @return ListResponse
     * @throws ApiException
     */
    public function getOffers(?OffersRequest $request = null): ListResponse
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
     * @param LeadsRequest|null $request
     * @return ListResponse
     * @throws ApiException
     */
    public function getLeads(?LeadsRequest $request = null): ListResponse
    {
        $params = $request?->toArray() ?? [];
        $response = $this->httpClient->get('leads', $params);
        return $this->parseListResponse($response, Lead::class);
    }

    /**
     * Получить информацию о лиде
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
     * Подтвердить лид
     * @param int $leadId
     * @return Lead
     * @throws ApiException
     */
    public function approveLead(int $leadId): Lead
    {
        $response = $this->httpClient->post("leads/{$leadId}/approve");
        return $this->parseResponse($response, Lead::class);
    }

    /**
     * Перевести лид в HOLD
     * @param int $leadId
     * @return Lead
     * @throws ApiException
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
     * @param int $leadId
     * @param CostLeadRequest $request
     * @return Lead
     * @throws ApiException
     */
    public function setLeadCost(int $leadId, CostLeadRequest $request): Lead
    {
        $response = $this->httpClient->post("leads/{$leadId}/cost", $request->toArray());
        return $this->parseResponse($response, Lead::class);
    }

    /**
     * Добавить лид для брокера
     * @param AddBrokerLeadRequest $request
     * @return BrokerLead
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
     * @return ListResponse
     * @throws ApiException
     */
    public function getAccounts(): ListResponse
    {
        $response = $this->httpClient->get('accounts');
        return $this->parseListResponse($response, Account::class);
    }
}
