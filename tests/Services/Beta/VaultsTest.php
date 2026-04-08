<?php

namespace Tests\Services\Beta;

use Anthropic\Beta\Vaults\BetaManagedAgentsDeletedVault;
use Anthropic\Beta\Vaults\BetaManagedAgentsVault;
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
final class VaultsTest extends TestCase
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
        $result = $this->client->beta->vaults->create(displayName: 'Example vault');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsVault::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->beta->vaults->create(
            displayName: 'Example vault',
            metadata: ['environment' => 'production'],
            betas: ['string'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsVault::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->beta->vaults->retrieve(
            'vlt_011CZkZDLs7fYzm1hXNPeRjv'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsVault::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->beta->vaults->update(
            'vlt_011CZkZDLs7fYzm1hXNPeRjv'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsVault::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('buildURL drops path-level query params (SDK-4349)');
        }

        $page = $this->client->beta->vaults->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(BetaManagedAgentsVault::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->beta->vaults->delete(
            'vlt_011CZkZDLs7fYzm1hXNPeRjv'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsDeletedVault::class, $result);
    }

    #[Test]
    public function testArchive(): void
    {
        $result = $this->client->beta->vaults->archive(
            'vlt_011CZkZDLs7fYzm1hXNPeRjv'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsVault::class, $result);
    }
}
