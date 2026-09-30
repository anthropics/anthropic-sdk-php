<?php

namespace Tests\Services\Beta\Organization;

use Anthropic\Beta\Organization\RBACGroups\RBACGroup;
use Anthropic\Beta\Organization\RBACGroups\RBACGroupDeleteResponse;
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
    public function testCreate(): void
    {
        $result = $this->client->beta->organization->rbacGroups->create(
            name: 'Engineering'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(RBACGroup::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->beta->organization->rbacGroups->create(
            name: 'Engineering'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(RBACGroup::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->beta->organization->rbacGroups->retrieve(
            'rbac_group_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(RBACGroup::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->beta->organization->rbacGroups->update(
            'rbac_group_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(RBACGroup::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->beta->organization->rbacGroups->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(RBACGroup::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->beta->organization->rbacGroups->delete(
            'rbac_group_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(RBACGroupDeleteResponse::class, $result);
    }
}
