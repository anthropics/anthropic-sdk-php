<?php

namespace Tests\Resources;

use Anthropic\Client;
use Anthropic\Completions\CompletionCreateParams;
use Anthropic\Messages\Metadata;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
final class CompletionsTest extends TestCase
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
        $result = $this
            ->client
            ->completions
            ->create(
                CompletionCreateParams::new(
                    maxTokensToSample: 256,
                    model: 'claude-3-7-sonnet-latest',
                    prompt: "\n\nHuman: Hello, world!\n\nAssistant:",
                )
            )
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this
            ->client
            ->completions
            ->create(
                CompletionCreateParams::new(
                    maxTokensToSample: 256,
                    model: 'claude-3-7-sonnet-latest',
                    prompt: "\n\nHuman: Hello, world!\n\nAssistant:",
                    metadata: (new Metadata)
                        ->setUserID('13803d75-b4b5-4c3e-b2a2-6f21399b021b'),
                    stopSequences: ['string'],
                    temperature: 1,
                    topK: 5,
                    topP: 0.7,
                    anthropicBeta: ['string'],
                )
            )
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }
}
