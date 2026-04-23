<?php

namespace Tests\Services\Beta;

use Anthropic\Beta\UserProfiles\BetaUserProfile;
use Anthropic\Beta\UserProfiles\BetaUserProfileEnrollmentURL;
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
        $result = $this->client->beta->userProfiles->create();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaUserProfile::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->beta->userProfiles->retrieve(
            'uprof_011CZkZCu8hGbp5mYRQgUmz9'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaUserProfile::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->beta->userProfiles->update(
            'uprof_011CZkZCu8hGbp5mYRQgUmz9'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaUserProfile::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->beta->userProfiles->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(BetaUserProfile::class, $item);
        }
    }

    #[Test]
    public function testCreateEnrollmentURL(): void
    {
        $result = $this->client->beta->userProfiles->createEnrollmentURL(
            'uprof_011CZkZCu8hGbp5mYRQgUmz9'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaUserProfileEnrollmentURL::class, $result);
    }
}
