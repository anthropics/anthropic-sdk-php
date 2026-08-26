<?php

namespace Tests\Services\Beta\Organization\Federation\Rules;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Federation\Rules\BetaFederationRuleWorkspace;
use Anthropic\Beta\Organization\Federation\Rules\Workspaces\WorkspaceRemoveResponse;
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
final class WorkspacesTest extends TestCase
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
    public function testList(): void
    {
        $page = $this
            ->client
            ->beta
            ->organization
            ->federation
            ->rules
            ->workspaces
            ->list('federation_rule_id')
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(BetaFederationRuleWorkspace::class, $item);
        }
    }

    #[Test]
    public function testAdd(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->federation
            ->rules
            ->workspaces
            ->add('federation_rule_id', workspaceID: 'workspace_id')
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaFederationRuleWorkspace::class, $result);
    }

    #[Test]
    public function testAddWithOptionalParams(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->federation
            ->rules
            ->workspaces
            ->add(
                'federation_rule_id',
                workspaceID: 'workspace_id',
                betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaFederationRuleWorkspace::class, $result);
    }

    #[Test]
    public function testRemove(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->federation
            ->rules
            ->workspaces
            ->remove('workspace_id', federationRuleID: 'federation_rule_id')
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(WorkspaceRemoveResponse::class, $result);
    }

    #[Test]
    public function testRemoveWithOptionalParams(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->federation
            ->rules
            ->workspaces
            ->remove(
                'workspace_id',
                federationRuleID: 'federation_rule_id',
                betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(WorkspaceRemoveResponse::class, $result);
    }
}
