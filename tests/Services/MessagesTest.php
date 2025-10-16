<?php

namespace Tests\Services;

use Anthropic\Client;
use Anthropic\Messages\MessageParam;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

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
        $result = $this->client->messages->create(
            maxTokens: 1024,
            messages: [MessageParam::with(content: 'Hello, world', role: 'user')],
            model: 'claude-sonnet-4-5-20250929',
        );

        $this->assertTrue(true); // @phpstan-ignore method.alreadyNarrowedType
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->messages->create(
            maxTokens: 1024,
            messages: [MessageParam::with(content: 'Hello, world', role: 'user')],
            model: 'claude-sonnet-4-5-20250929',
        );

        $this->assertTrue(true); // @phpstan-ignore method.alreadyNarrowedType
    }

    #[Test]
    public function testCountTokens(): void
    {
        $result = $this->client->messages->countTokens(
            messages: [MessageParam::with(content: 'string', role: 'user')],
            model: 'claude-3-7-sonnet-latest',
        );

        $this->assertTrue(true); // @phpstan-ignore method.alreadyNarrowedType
    }

    #[Test]
    public function testCountTokensWithOptionalParams(): void
    {
        $result = $this->client->messages->countTokens(
            messages: [MessageParam::with(content: 'string', role: 'user')],
            model: 'claude-3-7-sonnet-latest',
        );

        $this->assertTrue(true); // @phpstan-ignore method.alreadyNarrowedType
    }
}
