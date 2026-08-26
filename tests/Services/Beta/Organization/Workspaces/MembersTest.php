<?php

namespace Tests\Services\Beta\Organization\Workspaces;

use Anthropic\Beta\Organization\Workspaces\Members\MemberRemoveResponse;
use Anthropic\Beta\Organization\Workspaces\NoBillingWorkspaceRole;
use Anthropic\Beta\Organization\Workspaces\WorkspaceMember;
use Anthropic\Beta\Organization\Workspaces\WorkspaceRole;
use Anthropic\Client;
use Anthropic\Core\Util;
use Anthropic\Page;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
final class MembersTest extends TestCase
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
        $result = $this->client->beta->organization->workspaces->members->retrieve(
            'user_id',
            workspaceID: 'workspace_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(WorkspaceMember::class, $result);
    }

    #[Test]
    public function testRetrieveWithOptionalParams(): void
    {
        $result = $this->client->beta->organization->workspaces->members->retrieve(
            'user_id',
            workspaceID: 'workspace_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(WorkspaceMember::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->beta->organization->workspaces->members->update(
            'user_id',
            workspaceID: 'workspace_id',
            workspaceRole: WorkspaceRole::WORKSPACE_ADMIN,
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(WorkspaceMember::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        $result = $this->client->beta->organization->workspaces->members->update(
            'user_id',
            workspaceID: 'workspace_id',
            workspaceRole: WorkspaceRole::WORKSPACE_ADMIN,
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(WorkspaceMember::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->beta->organization->workspaces->members->list(
            'workspace_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Page::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(WorkspaceMember::class, $item);
        }
    }

    #[Test]
    public function testAdd(): void
    {
        $result = $this->client->beta->organization->workspaces->members->add(
            'workspace_id',
            userID: 'user_01WCz1FkmYMm4gnmykNKUu3Q',
            workspaceRole: NoBillingWorkspaceRole::WORKSPACE_ADMIN,
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(WorkspaceMember::class, $result);
    }

    #[Test]
    public function testAddWithOptionalParams(): void
    {
        $result = $this->client->beta->organization->workspaces->members->add(
            'workspace_id',
            userID: 'user_01WCz1FkmYMm4gnmykNKUu3Q',
            workspaceRole: NoBillingWorkspaceRole::WORKSPACE_ADMIN,
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(WorkspaceMember::class, $result);
    }

    #[Test]
    public function testRemove(): void
    {
        $result = $this->client->beta->organization->workspaces->members->remove(
            'user_id',
            workspaceID: 'workspace_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MemberRemoveResponse::class, $result);
    }

    #[Test]
    public function testRemoveWithOptionalParams(): void
    {
        $result = $this->client->beta->organization->workspaces->members->remove(
            'user_id',
            workspaceID: 'workspace_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MemberRemoveResponse::class, $result);
    }
}
