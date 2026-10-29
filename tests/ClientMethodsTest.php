<?php

declare(strict_types=1);

namespace Marketcall\Tests;

use Marketcall\AffiliateClient;
use Marketcall\MerchantClient;
use Marketcall\Requests\Affiliate\CallsCountRequest;
use Marketcall\Requests\Affiliate\CallsRequest as AffiliateCallsRequest;
use Marketcall\Requests\Affiliate\ChannelsRequest;
use Marketcall\Requests\Affiliate\CommentCallRequest;
use Marketcall\Requests\Affiliate\CreateProgramRequest;
use Marketcall\Requests\Affiliate\LeadsRequest as AffiliateLeadsRequest;
use Marketcall\Requests\Affiliate\OffersRequest as AffiliateOffersRequest;
use Marketcall\Requests\Affiliate\ProgramsRequest;
use Marketcall\Requests\Affiliate\RefuseCallRequest;
use Marketcall\Requests\Merchant\AddBrokerLeadRequest;
use Marketcall\Requests\Merchant\CallsRequest as MerchantCallsRequest;
use Marketcall\Requests\Merchant\CostLeadRequest;
use Marketcall\Requests\Merchant\LeadsRequest as MerchantLeadsRequest;
use Marketcall\Requests\Merchant\OffersRequest as MerchantOffersRequest;
use Marketcall\Requests\Merchant\RefuseLeadRequest;
use Marketcall\Transport\HttpClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;
use RuntimeException;

final class ClientMethodsTest extends TestCase
{
    #[DataProvider('affiliateMethods')]
    public function testAffiliateMethodCallsExpectedEndpoint(string $method, array $arguments, string $transportMethod, array $transportArguments): void
    {
        $this->assertMethodCallsEndpoint(AffiliateClient::class, $method, $arguments, $transportMethod, $transportArguments);
    }

    #[DataProvider('merchantMethods')]
    public function testMerchantMethodCallsExpectedEndpoint(string $method, array $arguments, string $transportMethod, array $transportArguments): void
    {
        $this->assertMethodCallsEndpoint(MerchantClient::class, $method, $arguments, $transportMethod, $transportArguments);
    }

    public static function affiliateMethods(): array
    {
        return [
            'calls' => ['getCalls', [new AffiliateCallsRequest()], 'get', ['calls', []]],
            'calls count' => ['getCallsCount', [new CallsCountRequest()], 'get', ['calls/count', []]],
            'call record' => ['getCallRecord', [23], 'getBinary', ['calls/23/record']],
            'phones without programs' => ['getPhones', [true], 'get', ['phones', ['without_programs' => 1]]],
            'regions' => ['getRegions', [], 'get', ['regions']],
            'categories' => ['getCategories', [], 'get', ['categories']],
            'offers' => ['getOffers', [new AffiliateOffersRequest()], 'get', ['offers', []]],
            'offer' => ['getOffer', [23], 'get', ['offers/23']],
            'incoming call ability' => ['getIncomingCallAbility', [23], 'get', ['offer/23/incoming-call-ability']],
            'offer tools' => ['getOfferTools', [23], 'get', ['offers/23/tools']],
            'programs' => ['getPrograms', [(new ProgramsRequest())->setOfferTypes(['calls'])], 'get', ['programs', ['offer_types' => ['calls']]]],
            'program' => ['getProgram', [23], 'get', ['programs/23']],
            'create program' => ['createProgram', [new CreateProgramRequest(1, 2, 'Test', ['calls'], 'source', 'https://example.test')], 'post', ['programs', ['offer_id' => 1, 'rent_id' => 2, 'title' => 'Test', 'traffic_sources' => ['calls'], 'traffic_comment' => 'source', 'trafficback_url' => 'https://example.test']]],
            'cancel program' => ['cancelProgram', [23], 'post', ['programs/23/cancel']],
            'promo materials' => ['getPromoMaterials', [[1], [2]], 'get', ['promo', ['programs' => [1], 'offers' => [2]]]],
            'withdraw' => ['withdraw', [['amount' => 100]], 'post', ['withdraw', ['amount' => 100]]],
            'expenses' => ['getExpenses', [['date_from' => '2025-01-01']], 'get', ['expense', ['date_from' => '2025-01-01']]],
            'create expense' => ['createExpense', [['amount' => 100]], 'post', ['expense', ['amount' => 100]]],
            'expense categories' => ['getExpenseCategories', [], 'get', ['expense/categories']],
            'create expense category' => ['createExpenseCategory', [['title' => 'Ads']], 'post', ['expense/categories', ['title' => 'Ads']]],
            'leads' => ['getLeads', [new AffiliateLeadsRequest()], 'get', ['leads', []]],
            'lead' => ['getLead', [23], 'get', ['leads/23']],
            'create lead' => ['createLead', [['channel_id' => 1]], 'post', ['leads', ['channel_id' => 1]]],
            'channels' => ['getChannels', [new ChannelsRequest()], 'get', ['channels', []]],
            'channel' => ['getChannel', [23], 'get', ['channels/23']],
            'create channel' => ['createChannel', ['Social'], 'post', ['channels', ['title' => 'Social']]],
            'lead ping' => ['sendLeadPing', [['phone' => '+10000000000']], 'post', ['lead-pings', ['phone' => '+10000000000']]],
            'broker leads' => ['getBrokerLeads', [['program' => 1]], 'get', ['broker/leads', ['program' => 1]]],
            'broker lead' => ['getBrokerLead', [23], 'get', ['broker/leads/23']],
            'delete broker lead' => ['deleteBrokerLead', [23], 'delete', ['broker/leads/23']],
            'create broker lead' => ['addBrokerLead', [['phone_number' => '+10000000000', 'program_id' => 1]], 'post', ['broker/leads', ['phone_number' => '+10000000000', 'program_id' => 1]]],
            'create postback' => ['createPostback', [['link' => 'https://example.test']], 'post', ['postbacks', ['link' => 'https://example.test']]],
            'postback templates' => ['getPostbackTemplates', [], 'get', ['postbacks/templates']],
        ];
    }

    public static function merchantMethods(): array
    {
        return [
            'calls' => ['getCalls', [new MerchantCallsRequest()], 'get', ['calls', []]],
            'call' => ['getCall', [23], 'get', ['calls/23']],
            'approve call' => ['approveCall', [23], 'post', ['calls/23/approve']],
            'refuse call' => ['refuseCall', [23, new RefuseCallRequest('reason')], 'post', ['calls/23/refuse', ['reason' => 'reason']]],
            'comment call' => ['commentCall', [23, new CommentCallRequest('comment')], 'post', ['calls/23/comment', ['comment' => 'comment']]],
            'offers' => ['getOffers', [new MerchantOffersRequest()], 'get', ['offers', []]],
            'offer' => ['getOffer', [23], 'get', ['offers/23']],
            'leads' => ['getLeads', [new MerchantLeadsRequest()], 'get', ['leads', []]],
            'lead' => ['getLead', [23], 'get', ['leads/23']],
            'approve lead' => ['approveLead', [23], 'post', ['leads/23/approve']],
            'hold lead' => ['holdLead', [23], 'post', ['leads/23/hold']],
            'refuse lead' => ['refuseLead', [23, new RefuseLeadRequest('reason')], 'post', ['leads/23/refuse', ['reason' => 'reason']]],
            'set lead cost' => ['setLeadCost', [23, new CostLeadRequest(12.5)], 'post', ['leads/23/cost', ['cost' => 12.5]]],
            'broker lead' => ['addBrokerLead', [new AddBrokerLeadRequest('+10000000000', 1)], 'post', ['broker/leads', ['phone_number' => '+10000000000', 'program_id' => 1]]],
            'accounts' => ['getAccounts', [], 'get', ['accounts']],
        ];
    }

    private function assertMethodCallsEndpoint(string $clientClass, string $method, array $arguments, string $transportMethod, array $transportArguments): void
    {
        $intercepted = new RuntimeException('transport intercepted');
        $httpClient = $this->getMockBuilder(HttpClient::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['get', 'getBinary', 'post', 'delete'])
            ->getMock();
        $httpClient->expects(self::once())
            ->method($transportMethod)
            ->with(...array_map(fn(mixed $argument) => self::identicalTo($argument), $transportArguments))
            ->willThrowException($intercepted);

        $client = new $clientClass('test-key');
        (new ReflectionProperty($clientClass, 'httpClient'))->setValue($client, $httpClient);

        try {
            $client->$method(...$arguments);
            self::fail('Expected transport interception');
        } catch (RuntimeException $exception) {
            self::assertSame($intercepted, $exception);
        }
    }
}
