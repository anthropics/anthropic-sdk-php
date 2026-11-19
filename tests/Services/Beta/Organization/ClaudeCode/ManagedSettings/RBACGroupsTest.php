<?php

namespace Tests\Services\Beta\Organization\ClaudeCode\ManagedSettings;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups\BetaClaudeCodeRBACGroupManagedSettings;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups\BetaClaudeCodeRBACGroupManagedSettingsSummary;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups\BetaDeletedClaudeCodeRBACGroupManagedSettings;
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
final class RBACGroupsTest extends TestCase
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
            ->rbacGroups
            ->retrieve(
                'rbac_group_id',
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(
            BetaClaudeCodeRBACGroupManagedSettings::class,
            $result
        );
    }

    #[Test]
    public function testList(): void
    {
        $page = $this
            ->client
            ->beta
            ->organization
            ->claudeCode
            ->managedSettings
            ->rbacGroups
            ->list(requestOptions: ['extraQueryParams' => ['beta' => 'true']])
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(
                BetaClaudeCodeRBACGroupManagedSettingsSummary::class,
                $item
            );
        }
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->claudeCode
            ->managedSettings
            ->rbacGroups
            ->delete(
                'rbac_group_id',
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(
            BetaDeletedClaudeCodeRBACGroupManagedSettings::class,
            $result
        );
    }

    #[Test]
    public function testSet(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->claudeCode
            ->managedSettings
            ->rbacGroups
            ->set(
                'rbac_group_id',
                settings: ['foo' => 'bar'],
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(
            BetaClaudeCodeRBACGroupManagedSettings::class,
            $result
        );
    }

    #[Test]
    public function testSetWithOptionalParams(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->claudeCode
            ->managedSettings
            ->rbacGroups
            ->set(
                'rbac_group_id',
                settings: ['foo' => 'bar'],
                betas: [AnthropicBeta::COMPUTER_USE_2024_10_22],
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(
            BetaClaudeCodeRBACGroupManagedSettings::class,
            $result
        );
    }
}
