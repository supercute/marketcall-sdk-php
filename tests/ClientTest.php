<?php

namespace Marketcall;

use Marketcall\Model\Lead;
use Marketcall\Model\Paginator;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ClientTest extends TestCase
{
    private MerchantClient $client;

    protected function setUp(): void
    {
        $this->client = new MerchantClient('dummy_key');
    }

    public function testParseListResponseReturnsTypedDataAndPaginator(): void
    {
        $response = [
            'request_id' => 'test-request-id-123',
            'data' => [
                ['id' => 1, 'offer_id' => 1, 'state' => 'approved', 'received_at' => '2025-01-01T00:00:00+00:00'],
                ['id' => 2, 'offer_id' => 2, 'state' => 'pending', 'received_at' => '2025-01-02T00:00:00+00:00'],
            ],
            'paginator' => [
                'current_page' => 1,
                'total_pages' => 5,
                'total_count' => 50,
                'limit' => 10,
            ]
        ];

        $reflection = new ReflectionClass($this->client);
        $method = $reflection->getMethod('parseListResponse');
        $method->setAccessible(true);

        $result = $method->invokeArgs($this->client, [$response, Lead::class]);

        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('paginator', $result);

        foreach ($result['data'] as $item) {
            $this->assertInstanceOf(Lead::class, $item);
        }

        $this->assertInstanceOf(Paginator::class, $result['paginator']);
        $this->assertSame('test-request-id-123', $this->client->getLastRequestId());
    }
}
