<?php

namespace Tests\Services\Beta\Organization\Federation;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Federation\Issuers\BetaFederationIssuer;
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
final class IssuersTest extends TestCase
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
        $result = $this->client->beta->organization->federation->issuers->create(
            issuerURL: 'x',
            name: 'x'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaFederationIssuer::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->beta->organization->federation->issuers->create(
            issuerURL: 'x',
            name: 'x',
            checkJTI: true,
            jwks: [
                'type' => 'discovery',
                'caCertPEM' => 'ca_cert_pem',
                'discoveryBase' => 'discovery_base',
            ],
            maxJWTLifetimeSeconds: 1,
            betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaFederationIssuer::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->beta->organization->federation->issuers->retrieve(
            'federation_issuer_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaFederationIssuer::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->beta->organization->federation->issuers->update(
            'federation_issuer_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaFederationIssuer::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->beta->organization->federation->issuers->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(BetaFederationIssuer::class, $item);
        }
    }

    #[Test]
    public function testArchive(): void
    {
        $result = $this->client->beta->organization->federation->issuers->archive(
            'federation_issuer_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaFederationIssuer::class, $result);
    }
}
