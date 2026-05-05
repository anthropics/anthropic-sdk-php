<?php

namespace Tests\Services\Beta\Sessions;

use Anthropic\Beta\Sessions\Threads\ManagedAgentsSessionThread;
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
final class ThreadsTest extends TestCase
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
        $result = $this->client->beta->sessions->threads->retrieve(
            'sthr_011CZkZVWa6oIjw0rgXZpnBt',
            sessionID: 'sesn_011CZkZAtmR3yMPDzynEDxu7',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsSessionThread::class, $result);
    }

    #[Test]
    public function testRetrieveWithOptionalParams(): void
    {
        $result = $this->client->beta->sessions->threads->retrieve(
            'sthr_011CZkZVWa6oIjw0rgXZpnBt',
            sessionID: 'sesn_011CZkZAtmR3yMPDzynEDxu7',
            betas: ['message-batches-2024-09-24'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsSessionThread::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('buildURL drops path-level query params (SDK-4349)');
        }

        $page = $this->client->beta->sessions->threads->list(
            'sesn_011CZkZAtmR3yMPDzynEDxu7'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(ManagedAgentsSessionThread::class, $item);
        }
    }

    #[Test]
    public function testArchive(): void
    {
        $result = $this->client->beta->sessions->threads->archive(
            'sthr_011CZkZVWa6oIjw0rgXZpnBt',
            sessionID: 'sesn_011CZkZAtmR3yMPDzynEDxu7',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsSessionThread::class, $result);
    }

    #[Test]
    public function testArchiveWithOptionalParams(): void
    {
        $result = $this->client->beta->sessions->threads->archive(
            'sthr_011CZkZVWa6oIjw0rgXZpnBt',
            sessionID: 'sesn_011CZkZAtmR3yMPDzynEDxu7',
            betas: ['message-batches-2024-09-24'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsSessionThread::class, $result);
    }
}
