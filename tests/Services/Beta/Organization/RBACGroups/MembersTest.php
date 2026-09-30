<?php

namespace Tests\Services\Beta\Organization\RBACGroups;

use Anthropic\Beta\Organization\RBACGroups\Members\BetaRBACGroupMember;
use Anthropic\Beta\Organization\RBACGroups\Members\MemberRemoveResponse;
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
    public function testList(): void
    {
        $page = $this->client->beta->organization->rbacGroups->members->list(
            'rbac_group_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(BetaRBACGroupMember::class, $item);
        }
    }

    #[Test]
    public function testAdd(): void
    {
        $result = $this->client->beta->organization->rbacGroups->members->add(
            'rbac_group_id',
            userID: 'user_01WCz1FkmYMm4gnmykNKUu3Q'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaRBACGroupMember::class, $result);
    }

    #[Test]
    public function testAddWithOptionalParams(): void
    {
        $result = $this->client->beta->organization->rbacGroups->members->add(
            'rbac_group_id',
            userID: 'user_01WCz1FkmYMm4gnmykNKUu3Q'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaRBACGroupMember::class, $result);
    }

    #[Test]
    public function testRemove(): void
    {
        $result = $this->client->beta->organization->rbacGroups->members->remove(
            'user_id',
            rbacGroupID: 'rbac_group_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MemberRemoveResponse::class, $result);
    }

    #[Test]
    public function testRemoveWithOptionalParams(): void
    {
        $result = $this->client->beta->organization->rbacGroups->members->remove(
            'user_id',
            rbacGroupID: 'rbac_group_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MemberRemoveResponse::class, $result);
    }
}
