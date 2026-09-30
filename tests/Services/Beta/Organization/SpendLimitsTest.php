<?php

namespace Tests\Services\Beta\Organization;

use Anthropic\Beta\Organization\SpendLimits\SpendLimit;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitDeleteResponse;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitPeriod;
use Anthropic\Client;
use Anthropic\Core\Util;
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
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SpendLimit::class, $result);
    }
}
