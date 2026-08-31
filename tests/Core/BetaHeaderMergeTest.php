<?php

namespace Tests\Core;

use Anthropic\Client;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * Verifies that the user-supplied `betas:` request param is not silently
 * overridden by per-endpoint `anthropic-beta` defaults that generated
 * services pass via `RequestOptions::extraHeaders`.
 *
 * @internal
 */
#[CoversNothing]
final class BetaHeaderMergeTest extends TestCase
{
    private MockClient $transporter;

    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->transporter = new MockClient;

        $mockRsp = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse()
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(
                Psr17FactoryDiscovery::findStreamFactory()
                    ->createStream('{"data":[],"next_page":null}')
            )
        ;
        $this->transporter->setDefaultResponse($mockRsp);

        $this->client = new Client(
            apiKey: 'my-anthropic-api-key',
            requestOptions: ['transporter' => $this->transporter],
        );
    }

    #[Test]
    public function testEndpointDefaultBetaSentWhenNoBetasGiven(): void
    {
        $this->client->beta->vaults->list();

        $this->assertSame(
            ['managed-agents-2026-04-01'],
            $this->getLastRequest()->getHeader('anthropic-beta'),
        );
    }

    #[Test]
    public function testBetasParamMergedWithEndpointDefault(): void
    {
        $this->client->beta->vaults->list(
            betas: ['mcp-client-2025-04-04'],
        );

        $this->assertSame(
            ['mcp-client-2025-04-04', 'managed-agents-2026-04-01'],
            $this->getLastRequest()->getHeader('anthropic-beta'),
        );
    }

    #[Test]
    public function testBetasParamDeduplicatedAgainstEndpointDefault(): void
    {
        $this->client->beta->vaults->list(
            betas: ['managed-agents-2026-04-01', 'mcp-client-2025-04-04'],
        );

        $this->assertSame(
            ['managed-agents-2026-04-01', 'mcp-client-2025-04-04'],
            $this->getLastRequest()->getHeader('anthropic-beta'),
        );
    }

    #[Test]
    public function testExtraHeadersOverrideReplacesEndpointDefault(): void
    {
        $this->client->beta->vaults->list(
            requestOptions: ['extraHeaders' => ['anthropic-beta' => 'custom-beta']],
        );

        $this->assertSame(
            ['custom-beta'],
            $this->getLastRequest()->getHeader('anthropic-beta'),
        );
    }

    #[Test]
    public function testBetasParamPassesThroughWithoutEndpointDefault(): void
    {
        $this->client->beta->messages->create(
            maxTokens: 1024,
            messages: [],
            model: 'claude-haiku-4-5',
            betas: ['mcp-client-2025-04-04'],
        );

        $this->assertSame(
            ['mcp-client-2025-04-04'],
            $this->getLastRequest()->getHeader('anthropic-beta'),
        );
    }

    private function getLastRequest(): RequestInterface
    {
        $request = $this->transporter->getLastRequest();
        assert($request instanceof RequestInterface);

        return $request;
    }
}
