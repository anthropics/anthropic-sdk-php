<?php

namespace Tests\Services\Beta\Organization\SpendLimits;

use Anthropic\Beta\Organization\SpendLimits\IncreaseRequests\BetaSpendLimitIncreaseRequest;
use Anthropic\Beta\Organization\SpendLimits\IncreaseRequests\IncreaseRequestApproveResponse;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitPeriod;
use Anthropic\Client;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
final class IncreaseRequestsTest extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $testUrl = Util::getenv('TEST_API_BASE_URL') ?: 'http://127.0.0.1:4010';
        $client = new Client(apiKey: 'my-anthropic-api-key', baseUrl: $testUrl);

        $this->client = $client;
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->spendLimits
            ->increaseRequests
            ->retrieve('spend_limit_increase_request_id')
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaSpendLimitIncreaseRequest::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this
            ->client
            ->beta
            ->organization
            ->spendLimits
            ->increaseRequests
            ->list()
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(BetaSpendLimitIncreaseRequest::class, $item);
        }
    }

    #[Test]
    public function testApprove(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->spendLimits
            ->increaseRequests
            ->approve('spend_limit_increase_request_id', amount: '50000')
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(IncreaseRequestApproveResponse::class, $result);
    }

    #[Test]
    public function testApproveWithOptionalParams(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->spendLimits
            ->increaseRequests
            ->approve(
                'spend_limit_increase_request_id',
                amount: '50000',
                period: SpendLimitPeriod::MONTHLY,
                suppressNotification: true,
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(IncreaseRequestApproveResponse::class, $result);
    }

    #[Test]
    public function testDeny(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->spendLimits
            ->increaseRequests
            ->deny('spend_limit_increase_request_id')
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaSpendLimitIncreaseRequest::class, $result);
    }
}
