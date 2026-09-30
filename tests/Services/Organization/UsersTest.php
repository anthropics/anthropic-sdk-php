<?php

namespace Tests\Services\Organization;

use Anthropic\Client;
use Anthropic\Core\Util;
use Anthropic\Organization\Users\OrganizationUser;
use Anthropic\Organization\Users\UserRemoveResponse;
use Anthropic\Page;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
final class UsersTest extends TestCase
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
        $result = $this->client->organization->users->retrieve('user_id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(OrganizationUser::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->organization->users->update(
            'user_id',
            role: 'user'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(OrganizationUser::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        $result = $this->client->organization->users->update(
            'user_id',
            role: 'user'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(OrganizationUser::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->organization->users->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Page::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(OrganizationUser::class, $item);
        }
    }

    #[Test]
    public function testRemove(): void
    {
        $result = $this->client->organization->users->remove('user_id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserRemoveResponse::class, $result);
    }
}
