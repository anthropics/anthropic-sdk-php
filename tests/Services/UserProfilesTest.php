<?php

namespace Tests\Services;

use Anthropic\Client;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\UserProfiles\DeletedUserProfile;
use Anthropic\UserProfiles\UserProfile;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
final class UserProfilesTest extends TestCase
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
        $result = $this->client->userProfiles->create();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserProfile::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->userProfiles->retrieve(
            'uprof_011CZkZCu8hGbp5mYRQgUmz9'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserProfile::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->userProfiles->update(
            'uprof_011CZkZCu8hGbp5mYRQgUmz9'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserProfile::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->userProfiles->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(UserProfile::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->userProfiles->delete(
            'uprof_011CZkZCu8hGbp5mYRQgUmz9'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DeletedUserProfile::class, $result);
    }
}
