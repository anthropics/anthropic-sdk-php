<?php

namespace Tests\Services\Beta;

use Anthropic\Client;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;

/**
 * @internal
 */
#[CoversNothing]
final class MessagesTest extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $testUrl = getenv('TEST_API_BASE_URL') ?: 'http://127.0.0.1:4010';
        $client = new Client(apiKey: 'my-anthropic-api-key', baseUrl: $testUrl);

        $this->client = $client;
    }

    #[Test]
    public function testCreate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('prism validates based on the non-beta endpoint');
        }

        $result = $this->client->beta->messages->create([
            'max_tokens' => 1024,
            'messages' => [['content' => 'Hello, world', 'role' => 'user']],
            'model' => 'claude-sonnet-4-5-20250929',
        ]);

        $this->assertTrue(true); // @phpstan-ignore method.alreadyNarrowedType
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('prism validates based on the non-beta endpoint');
        }

        $result = $this->client->beta->messages->create([
            'max_tokens' => 1024,
            'messages' => [['content' => 'Hello, world', 'role' => 'user']],
            'model' => 'claude-sonnet-4-5-20250929',
        ]);

        $this->assertTrue(true); // @phpstan-ignore method.alreadyNarrowedType
    }

    #[Test]
    public function testCountTokens(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('prism validates based on the non-beta endpoint');
        }

        $result = $this->client->beta->messages->countTokens([
            'messages' => [['content' => 'string', 'role' => 'user']],
            'model' => 'claude-3-7-sonnet-latest',
        ]);

        $this->assertTrue(true); // @phpstan-ignore method.alreadyNarrowedType
    }

    #[Test]
    public function testCountTokensWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('prism validates based on the non-beta endpoint');
        }

        $result = $this->client->beta->messages->countTokens([
            'messages' => [['content' => 'string', 'role' => 'user']],
            'model' => 'claude-3-7-sonnet-latest',
        ]);

        $this->assertTrue(true); // @phpstan-ignore method.alreadyNarrowedType
    }
}
