<?php

namespace Tests\Services\Beta\UserProfiles\Providers\Google;

use Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedDataControls;
use Anthropic\Client;
use Anthropic\Core\Util;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
final class DataControlsTest extends TestCase
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
            ->userProfiles
            ->providers
            ->google
            ->dataControls
            ->retrieve(
                'uprof_011CZkZCu8hGbp5mYRQgUmz9',
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaGoogleManagedDataControls::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this
            ->client
            ->beta
            ->userProfiles
            ->providers
            ->google
            ->dataControls
            ->update(
                'uprof_011CZkZCu8hGbp5mYRQgUmz9',
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaGoogleManagedDataControls::class, $result);
    }
}
