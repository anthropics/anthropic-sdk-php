<?php

namespace Tests\Services\Beta\Environments;

use Anthropic\Beta\Environments\Work\SelfHostedWork;
use Anthropic\Beta\Environments\Work\SelfHostedWorkHeartbeatResponse;
use Anthropic\Beta\Environments\Work\SelfHostedWorkQueueStats;
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
final class WorkTest extends TestCase
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
        $result = $this->client->beta->environments->work->retrieve(
            'work_id',
            environmentID: 'env_011CZkZ9X2dpNyB7HsEFoRfW'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SelfHostedWork::class, $result);
    }

    #[Test]
    public function testRetrieveWithOptionalParams(): void
    {
        $result = $this->client->beta->environments->work->retrieve(
            'work_id',
            environmentID: 'env_011CZkZ9X2dpNyB7HsEFoRfW',
            betas: ['message-batches-2024-09-24'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SelfHostedWork::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->beta->environments->work->update(
            'work_id',
            environmentID: 'env_011CZkZ9X2dpNyB7HsEFoRfW',
            metadata: ['foo' => 'string'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SelfHostedWork::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        $result = $this->client->beta->environments->work->update(
            'work_id',
            environmentID: 'env_011CZkZ9X2dpNyB7HsEFoRfW',
            metadata: ['foo' => 'string'],
            betas: ['message-batches-2024-09-24'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SelfHostedWork::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('buildURL drops path-level query params (SDK-4349)');
        }

        $page = $this->client->beta->environments->work->list(
            'env_011CZkZ9X2dpNyB7HsEFoRfW'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(SelfHostedWork::class, $item);
        }
    }

    #[Test]
    public function testAck(): void
    {
        $result = $this->client->beta->environments->work->ack(
            'work_id',
            environmentID: 'env_011CZkZ9X2dpNyB7HsEFoRfW'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SelfHostedWork::class, $result);
    }

    #[Test]
    public function testAckWithOptionalParams(): void
    {
        $result = $this->client->beta->environments->work->ack(
            'work_id',
            environmentID: 'env_011CZkZ9X2dpNyB7HsEFoRfW',
            betas: ['message-batches-2024-09-24'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SelfHostedWork::class, $result);
    }

    #[Test]
    public function testHeartbeat(): void
    {
        $result = $this->client->beta->environments->work->heartbeat(
            'work_id',
            environmentID: 'env_011CZkZ9X2dpNyB7HsEFoRfW'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SelfHostedWorkHeartbeatResponse::class, $result);
    }

    #[Test]
    public function testHeartbeatWithOptionalParams(): void
    {
        $result = $this->client->beta->environments->work->heartbeat(
            'work_id',
            environmentID: 'env_011CZkZ9X2dpNyB7HsEFoRfW',
            desiredTTLSeconds: 0,
            expectedLastHeartbeat: 'expected_last_heartbeat',
            betas: ['message-batches-2024-09-24'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SelfHostedWorkHeartbeatResponse::class, $result);
    }

    #[Test]
    public function testPoll(): void
    {
        $result = $this->client->beta->environments->work->poll(
            'env_011CZkZ9X2dpNyB7HsEFoRfW'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SelfHostedWork::class, $result);
    }

    #[Test]
    public function testStats(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('buildURL drops path-level query params (SDK-4349)');
        }

        $result = $this->client->beta->environments->work->stats(
            'env_011CZkZ9X2dpNyB7HsEFoRfW'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SelfHostedWorkQueueStats::class, $result);
    }

    #[Test]
    public function testStop(): void
    {
        $result = $this->client->beta->environments->work->stop(
            'work_id',
            environmentID: 'env_011CZkZ9X2dpNyB7HsEFoRfW'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SelfHostedWork::class, $result);
    }

    #[Test]
    public function testStopWithOptionalParams(): void
    {
        $result = $this->client->beta->environments->work->stop(
            'work_id',
            environmentID: 'env_011CZkZ9X2dpNyB7HsEFoRfW',
            force: true,
            betas: ['message-batches-2024-09-24'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SelfHostedWork::class, $result);
    }
}
