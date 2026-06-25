<?php

namespace Tests\Services\Beta;

use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsDeploymentRun;
use Anthropic\Beta\Deployments\BetaManagedAgentsDeployment;
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
final class DeploymentsTest extends TestCase
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
        $result = $this->client->beta->deployments->create(
            agent: 'string',
            environmentID: 'x',
            initialEvents: [
                [
                    'content' => [
                        ['text' => 'Where is my order #1234?', 'type' => 'text'],
                    ],
                    'type' => 'user.message',
                ],
            ],
            name: 'x',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsDeployment::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->beta->deployments->create(
            agent: 'string',
            environmentID: 'x',
            initialEvents: [
                [
                    'content' => [
                        ['text' => 'Where is my order #1234?', 'type' => 'text'],
                    ],
                    'type' => 'user.message',
                ],
            ],
            name: 'x',
            description: 'description',
            metadata: ['foo' => 'string'],
            resources: [
                [
                    'fileID' => 'file_011CNha8iCJcU1wXNR6q4V8w',
                    'type' => 'file',
                    'mountPath' => '/uploads/receipt.pdf',
                ],
            ],
            schedule: [
                'expression' => '0 9 * * 1-5',
                'timezone' => 'America/Los_Angeles',
                'type' => 'cron',
            ],
            vaultIDs: ['string'],
            betas: ['message-batches-2024-09-24'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsDeployment::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('buildURL drops path-level query params (SDK-4349)');
        }

        $result = $this->client->beta->deployments->retrieve(
            'depl_011CZkZcDH3vPqd7xnEfwTai'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsDeployment::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->beta->deployments->update(
            'depl_011CZkZcDH3vPqd7xnEfwTai'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsDeployment::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('buildURL drops path-level query params (SDK-4349)');
        }

        $page = $this->client->beta->deployments->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(BetaManagedAgentsDeployment::class, $item);
        }
    }

    #[Test]
    public function testArchive(): void
    {
        $result = $this->client->beta->deployments->archive(
            'depl_011CZkZcDH3vPqd7xnEfwTai'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsDeployment::class, $result);
    }

    #[Test]
    public function testPause(): void
    {
        $result = $this->client->beta->deployments->pause(
            'depl_011CZkZcDH3vPqd7xnEfwTai'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsDeployment::class, $result);
    }

    #[Test]
    public function testRun(): void
    {
        $result = $this->client->beta->deployments->run(
            'depl_011CZkZcDH3vPqd7xnEfwTai'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsDeploymentRun::class, $result);
    }

    #[Test]
    public function testUnpause(): void
    {
        $result = $this->client->beta->deployments->unpause(
            'depl_011CZkZcDH3vPqd7xnEfwTai'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsDeployment::class, $result);
    }
}
