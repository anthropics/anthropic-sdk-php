<?php

namespace Tests\Resources\Beta;

use Anthropic\Beta\Messages\BetaMessageParam;
use Anthropic\Client;
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
        $result = $this->client->beta->messages->create(
            maxTokens: 1024,
            messages: [BetaMessageParam::with(content: 'Hello, world', role: 'user')],
            model: 'claude-sonnet-4-20250514',
        );

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->beta->messages->create(
            maxTokens: 1024,
            messages: [BetaMessageParam::with(content: 'Hello, world', role: 'user')],
            model: 'claude-sonnet-4-20250514',
        );

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCountTokens(): void
    {
        $result = $this->client->beta->messages->countTokens(
            messages: [BetaMessageParam::with(content: 'string', role: 'user')],
            model: 'claude-3-7-sonnet-latest',
        );

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCountTokensWithOptionalParams(): void
    {
        $result = $this->client->beta->messages->countTokens(
            messages: [BetaMessageParam::with(content: 'string', role: 'user')],
            model: 'claude-3-7-sonnet-latest',
        );

        $this->assertTrue(true); // @phpstan-ignore-line
    }
}
