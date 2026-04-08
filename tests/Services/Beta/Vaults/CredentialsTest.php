<?php

namespace Tests\Services\Beta\Vaults;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsCredential;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsDeletedCredential;
use Anthropic\Client;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;

/**
 * @internal
 */
#[CoversNothing]
final class CredentialsTest extends TestCase
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
        $result = $this->client->beta->vaults->credentials->create(
            'vlt_011CZkZDLs7fYzm1hXNPeRjv',
            auth: [
                'token' => 'bearer_exampletoken',
                'mcpServerURL' => 'https://example-server.modelcontextprotocol.io/sse',
                'type' => 'static_bearer',
            ],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsCredential::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->beta->vaults->credentials->create(
            'vlt_011CZkZDLs7fYzm1hXNPeRjv',
            auth: [
                'token' => 'bearer_exampletoken',
                'mcpServerURL' => 'https://example-server.modelcontextprotocol.io/sse',
                'type' => 'static_bearer',
            ],
            displayName: 'Example credential',
            metadata: ['environment' => 'production'],
            betas: ['string'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsCredential::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->beta->vaults->credentials->retrieve(
            'vcrd_011CZkZEMt8gZan2iYOQfSkw',
            vaultID: 'vlt_011CZkZDLs7fYzm1hXNPeRjv'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsCredential::class, $result);
    }

    #[Test]
    public function testRetrieveWithOptionalParams(): void
    {
        $result = $this->client->beta->vaults->credentials->retrieve(
            'vcrd_011CZkZEMt8gZan2iYOQfSkw',
            vaultID: 'vlt_011CZkZDLs7fYzm1hXNPeRjv',
            betas: ['string'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsCredential::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->beta->vaults->credentials->update(
            'vcrd_011CZkZEMt8gZan2iYOQfSkw',
            vaultID: 'vlt_011CZkZDLs7fYzm1hXNPeRjv'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsCredential::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        $result = $this->client->beta->vaults->credentials->update(
            'vcrd_011CZkZEMt8gZan2iYOQfSkw',
            vaultID: 'vlt_011CZkZDLs7fYzm1hXNPeRjv',
            auth: [
                'type' => 'mcp_oauth',
                'accessToken' => 'x',
                'expiresAt' => new \DateTimeImmutable('2019-12-27T18:11:19.117Z'),
                'refresh' => [
                    'refreshToken' => 'x',
                    'scope' => 'scope',
                    'tokenEndpointAuth' => [
                        'type' => 'client_secret_basic', 'clientSecret' => 'x',
                    ],
                ],
            ],
            displayName: 'Example credential',
            metadata: ['environment' => 'production'],
            betas: ['string'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsCredential::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('buildURL drops path-level query params (SDK-4349)');
        }

        $page = $this->client->beta->vaults->credentials->list(
            'vlt_011CZkZDLs7fYzm1hXNPeRjv'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(ManagedAgentsCredential::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->beta->vaults->credentials->delete(
            'vcrd_011CZkZEMt8gZan2iYOQfSkw',
            vaultID: 'vlt_011CZkZDLs7fYzm1hXNPeRjv'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsDeletedCredential::class, $result);
    }

    #[Test]
    public function testDeleteWithOptionalParams(): void
    {
        $result = $this->client->beta->vaults->credentials->delete(
            'vcrd_011CZkZEMt8gZan2iYOQfSkw',
            vaultID: 'vlt_011CZkZDLs7fYzm1hXNPeRjv',
            betas: ['string'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsDeletedCredential::class, $result);
    }

    #[Test]
    public function testArchive(): void
    {
        $result = $this->client->beta->vaults->credentials->archive(
            'vcrd_011CZkZEMt8gZan2iYOQfSkw',
            vaultID: 'vlt_011CZkZDLs7fYzm1hXNPeRjv'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsCredential::class, $result);
    }

    #[Test]
    public function testArchiveWithOptionalParams(): void
    {
        $result = $this->client->beta->vaults->credentials->archive(
            'vcrd_011CZkZEMt8gZan2iYOQfSkw',
            vaultID: 'vlt_011CZkZDLs7fYzm1hXNPeRjv',
            betas: ['string'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsCredential::class, $result);
    }
}
