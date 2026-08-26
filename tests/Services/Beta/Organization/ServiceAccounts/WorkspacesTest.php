<?php

namespace Tests\Services\Beta\Organization\ServiceAccounts;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountWorkspaceMember;
use Anthropic\Beta\Organization\ServiceAccounts\Workspaces\WorkspaceRemoveResponse;
use Anthropic\Beta\Organization\Workspaces\NoBillingWorkspaceRole;
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
            ->serviceAccounts
            ->workspaces
            ->list('service_account_id')
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(ServiceAccountWorkspaceMember::class, $item);
        }
    }

    #[Test]
    public function testAdd(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->serviceAccounts
            ->workspaces
            ->add(
                'service_account_id',
                workspaceID: 'workspace_id',
                workspaceRole: NoBillingWorkspaceRole::WORKSPACE_ADMIN,
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ServiceAccountWorkspaceMember::class, $result);
    }

    #[Test]
    public function testAddWithOptionalParams(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->serviceAccounts
            ->workspaces
            ->add(
                'service_account_id',
                workspaceID: 'workspace_id',
                workspaceRole: NoBillingWorkspaceRole::WORKSPACE_ADMIN,
                betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ServiceAccountWorkspaceMember::class, $result);
    }

    #[Test]
    public function testRemove(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->serviceAccounts
            ->workspaces
            ->remove('workspace_id', serviceAccountID: 'service_account_id')
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
            ->serviceAccounts
            ->workspaces
            ->remove(
                'workspace_id',
                serviceAccountID: 'service_account_id',
                betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(WorkspaceRemoveResponse::class, $result);
    }
}
