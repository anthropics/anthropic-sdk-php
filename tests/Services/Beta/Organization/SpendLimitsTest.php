<?php

namespace Tests\Services\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\SpendLimits\SpendLimit;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitDeleteResponse;
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
final class SpendLimitsTest extends TestCase
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
        $result = $this->client->beta->organization->spendLimits->retrieve(
            'spend_limit_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SpendLimit::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->beta->organization->spendLimits->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(SpendLimit::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->beta->organization->spendLimits->delete(
            'spend_limit_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SpendLimitDeleteResponse::class, $result);
    }

    #[Test]
    public function testSet(): void
    {
        $result = $this->client->beta->organization->spendLimits->set(
            amount: '50000',
            scope: ['type' => 'user', 'userID' => 'user_01WCz1FkmYMm4gnmykNKUu3Q'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SpendLimit::class, $result);
    }

    #[Test]
    public function testSetWithOptionalParams(): void
    {
        $result = $this->client->beta->organization->spendLimits->set(
            amount: '50000',
            scope: ['type' => 'user', 'userID' => 'user_01WCz1FkmYMm4gnmykNKUu3Q'],
            period: SpendLimitPeriod::MONTHLY,
            betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SpendLimit::class, $result);
    }
}
