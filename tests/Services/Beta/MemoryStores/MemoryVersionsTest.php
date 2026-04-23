<?php

namespace Tests\Services\Beta\MemoryStores;

use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryView;
use Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsMemoryVersion;
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
final class MemoryVersionsTest extends TestCase
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
    public function testRetrieve(): void
    {
        $result = $this->client->beta->memoryStores->memoryVersions->retrieve(
            'memory_version_id',
            memoryStoreID: 'memory_store_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsMemoryVersion::class, $result);
    }

    #[Test]
    public function testRetrieveWithOptionalParams(): void
    {
        $result = $this->client->beta->memoryStores->memoryVersions->retrieve(
            'memory_version_id',
            memoryStoreID: 'memory_store_id',
            view: ManagedAgentsMemoryView::BASIC,
            betas: ['message-batches-2024-09-24'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsMemoryVersion::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('buildURL drops path-level query params (SDK-4349)');
        }

        $page = $this->client->beta->memoryStores->memoryVersions->list(
            'memory_store_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(ManagedAgentsMemoryVersion::class, $item);
        }
    }

    #[Test]
    public function testRedact(): void
    {
        $result = $this->client->beta->memoryStores->memoryVersions->redact(
            'memory_version_id',
            memoryStoreID: 'memory_store_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsMemoryVersion::class, $result);
    }

    #[Test]
    public function testRedactWithOptionalParams(): void
    {
        $result = $this->client->beta->memoryStores->memoryVersions->redact(
            'memory_version_id',
            memoryStoreID: 'memory_store_id',
            betas: ['message-batches-2024-09-24'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsMemoryVersion::class, $result);
    }
}
