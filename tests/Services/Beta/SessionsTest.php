<?php

namespace Tests\Services\Beta;

use Anthropic\Beta\Sessions\BetaManagedAgentsDeletedSession;
use Anthropic\Beta\Sessions\BetaManagedAgentsSession;
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
final class SessionsTest extends TestCase
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
        $result = $this->client->beta->sessions->create(
            agent: 'agent_011CZkYpogX7uDKUyvBTophP',
            environmentID: 'env_011CZkZ9X2dpNyB7HsEFoRfW',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsSession::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->beta->sessions->create(
            agent: 'agent_011CZkYpogX7uDKUyvBTophP',
            environmentID: 'env_011CZkZ9X2dpNyB7HsEFoRfW',
            metadata: ['foo' => 'string'],
            resources: [
                [
                    'fileID' => 'file_011CNha8iCJcU1wXNR6q4V8w',
                    'type' => 'file',
                    'mountPath' => '/uploads/receipt.pdf',
                ],
            ],
            title: 'Order #1234 inquiry',
            vaultIDs: ['string'],
            betas: ['string'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsSession::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->beta->sessions->retrieve(
            'sesn_011CZkZAtmR3yMPDzynEDxu7'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsSession::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->beta->sessions->update(
            'sesn_011CZkZAtmR3yMPDzynEDxu7'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsSession::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('buildURL drops path-level query params (SDK-4349)');
        }

        $page = $this->client->beta->sessions->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(BetaManagedAgentsSession::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->beta->sessions->delete(
            'sesn_011CZkZAtmR3yMPDzynEDxu7'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsDeletedSession::class, $result);
    }

    #[Test]
    public function testArchive(): void
    {
        $result = $this->client->beta->sessions->archive(
            'sesn_011CZkZAtmR3yMPDzynEDxu7'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsSession::class, $result);
    }
}
