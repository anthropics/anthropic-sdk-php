<?php

namespace Tests\Services\Beta\Organization\ClaudeCode\ManagedSettings;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroupDefault\BetaClaudeCodeRBACGroupDefaultManagedSettings;
use Anthropic\Client;
use Anthropic\Core\Util;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
final class RBACGroupDefaultTest extends TestCase
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
            ->claudeCode
            ->managedSettings
            ->rbacGroupDefault
            ->retrieve(requestOptions: ['extraQueryParams' => ['beta' => 'true']])
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(
            BetaClaudeCodeRBACGroupDefaultManagedSettings::class,
            $result
        );
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->claudeCode
            ->managedSettings
            ->rbacGroupDefault
            ->update(
                settings: ['foo' => 'bar'],
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(
            BetaClaudeCodeRBACGroupDefaultManagedSettings::class,
            $result
        );
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->claudeCode
            ->managedSettings
            ->rbacGroupDefault
            ->update(
                settings: ['foo' => 'bar'],
                betas: [AnthropicBeta::COMPUTER_USE_2024_10_22],
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(
            BetaClaudeCodeRBACGroupDefaultManagedSettings::class,
            $result
        );
    }
}
