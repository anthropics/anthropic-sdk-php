<?php

namespace Tests\Services\UserProfiles;

use Anthropic\Client;
use Anthropic\Core\Util;
use Anthropic\UserProfiles\ActionURLs\UserProfileActionURL;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
final class ActionURLsTest extends TestCase
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
        $result = $this->client->userProfiles->actionURLs->create(
            'uprof_011CZkZCu8hGbp5mYRQgUmz9',
            action: ['type' => 'enroll_end_user']
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserProfileActionURL::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->userProfiles->actionURLs->create(
            'uprof_011CZkZCu8hGbp5mYRQgUmz9',
            action: ['type' => 'enroll_end_user'],
            workspaceID: 'wrkspc_011CZkZaBF1tNoB5wlCeusgy',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserProfileActionURL::class, $result);
    }
}
