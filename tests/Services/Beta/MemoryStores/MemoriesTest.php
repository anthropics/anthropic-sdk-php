<?php

namespace Tests\Services\Beta\MemoryStores;

use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsDeletedMemory;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemory;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryView;
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
final class MemoriesTest extends TestCase
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
        $result = $this->client->beta->memoryStores->memories->create(
            'memory_store_id',
            content: 'content',
            path: 'xx'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsMemory::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->beta->memoryStores->memories->create(
            'memory_store_id',
            content: 'content',
            path: 'xx',
            view: ManagedAgentsMemoryView::BASIC,
            betas: ['message-batches-2024-09-24'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsMemory::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->beta->memoryStores->memories->retrieve(
            'memory_id',
            memoryStoreID: 'memory_store_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsMemory::class, $result);
    }

    #[Test]
    public function testRetrieveWithOptionalParams(): void
    {
        $result = $this->client->beta->memoryStores->memories->retrieve(
            'memory_id',
            memoryStoreID: 'memory_store_id',
            view: ManagedAgentsMemoryView::BASIC,
            betas: ['message-batches-2024-09-24'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsMemory::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->beta->memoryStores->memories->update(
            'memory_id',
            memoryStoreID: 'memory_store_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsMemory::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        $result = $this->client->beta->memoryStores->memories->update(
            'memory_id',
            memoryStoreID: 'memory_store_id',
            view: ManagedAgentsMemoryView::BASIC,
            content: 'content',
            path: 'xx',
            precondition: [
                'type' => 'content_sha256', 'contentSha256' => 'content_sha256',
            ],
            betas: ['message-batches-2024-09-24'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsMemory::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('buildURL drops path-level query params (SDK-4349)');
        }

        $page = $this->client->beta->memoryStores->memories->list(
            'memory_store_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertNotNull($item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->beta->memoryStores->memories->delete(
            'memory_id',
            memoryStoreID: 'memory_store_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsDeletedMemory::class, $result);
    }

    #[Test]
    public function testDeleteWithOptionalParams(): void
    {
        $result = $this->client->beta->memoryStores->memories->delete(
            'memory_id',
            memoryStoreID: 'memory_store_id',
            expectedContentSha256: 'expected_content_sha256',
            betas: ['message-batches-2024-09-24'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsDeletedMemory::class, $result);
    }
}
