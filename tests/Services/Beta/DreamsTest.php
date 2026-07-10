<?php

namespace Tests\Services\Beta;

use Anthropic\Beta\Dreams\BetaDream;
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
final class DreamsTest extends TestCase
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
        $result = $this->client->beta->dreams->create(
            inputs: [['memoryStoreID' => 'x', 'type' => 'memory_store']],
            model: 'string',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaDream::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->beta->dreams->create(
            inputs: [['memoryStoreID' => 'x', 'type' => 'memory_store']],
            model: 'string',
            instructions: 'x',
            betas: ['message-batches-2024-09-24'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaDream::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->beta->dreams->retrieve('dream_id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaDream::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->beta->dreams->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(BetaDream::class, $item);
        }
    }

    #[Test]
    public function testArchive(): void
    {
        $result = $this->client->beta->dreams->archive('dream_id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaDream::class, $result);
    }

    #[Test]
    public function testCancel(): void
    {
        $result = $this->client->beta->dreams->cancel('dream_id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaDream::class, $result);
    }
}
