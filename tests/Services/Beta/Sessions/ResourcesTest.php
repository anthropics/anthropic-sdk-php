<?php

namespace Tests\Services\Beta\Sessions;

use Anthropic\Beta\Sessions\Resources\ManagedAgentsDeleteSessionResource;
use Anthropic\Beta\Sessions\Resources\ManagedAgentsFileResource;
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
final class ResourcesTest extends TestCase
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
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('prism can\'t find endpoint with beta only tag');
        }

        $result = $this->client->beta->sessions->resources->retrieve(
            'sesrsc_011CZkZBJq5dWxk9fVLNcPht',
            sessionID: 'sesn_011CZkZAtmR3yMPDzynEDxu7',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNotNull($result);
    }

    #[Test]
    public function testRetrieveWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('prism can\'t find endpoint with beta only tag');
        }

        $result = $this->client->beta->sessions->resources->retrieve(
            'sesrsc_011CZkZBJq5dWxk9fVLNcPht',
            sessionID: 'sesn_011CZkZAtmR3yMPDzynEDxu7',
            betas: ['string'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNotNull($result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('prism can\'t find endpoint with beta only tag');
        }

        $result = $this->client->beta->sessions->resources->update(
            'sesrsc_011CZkZBJq5dWxk9fVLNcPht',
            sessionID: 'sesn_011CZkZAtmR3yMPDzynEDxu7',
            authorizationToken: 'ghp_exampletoken',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNotNull($result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('prism can\'t find endpoint with beta only tag');
        }

        $result = $this->client->beta->sessions->resources->update(
            'sesrsc_011CZkZBJq5dWxk9fVLNcPht',
            sessionID: 'sesn_011CZkZAtmR3yMPDzynEDxu7',
            authorizationToken: 'ghp_exampletoken',
            betas: ['string'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNotNull($result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('prism can\'t find endpoint with beta only tag');
        }

        $page = $this->client->beta->sessions->resources->list(
            'sesn_011CZkZAtmR3yMPDzynEDxu7'
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
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('prism can\'t find endpoint with beta only tag');
        }

        $result = $this->client->beta->sessions->resources->delete(
            'sesrsc_011CZkZBJq5dWxk9fVLNcPht',
            sessionID: 'sesn_011CZkZAtmR3yMPDzynEDxu7',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsDeleteSessionResource::class, $result);
    }

    #[Test]
    public function testDeleteWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('prism can\'t find endpoint with beta only tag');
        }

        $result = $this->client->beta->sessions->resources->delete(
            'sesrsc_011CZkZBJq5dWxk9fVLNcPht',
            sessionID: 'sesn_011CZkZAtmR3yMPDzynEDxu7',
            betas: ['string'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsDeleteSessionResource::class, $result);
    }

    #[Test]
    public function testAdd(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('prism can\'t find endpoint with beta only tag');
        }

        $result = $this->client->beta->sessions->resources->add(
            'sesn_011CZkZAtmR3yMPDzynEDxu7',
            fileID: 'file_011CNha8iCJcU1wXNR6q4V8w',
            type: 'file',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsFileResource::class, $result);
    }

    #[Test]
    public function testAddWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('prism can\'t find endpoint with beta only tag');
        }

        $result = $this->client->beta->sessions->resources->add(
            'sesn_011CZkZAtmR3yMPDzynEDxu7',
            fileID: 'file_011CNha8iCJcU1wXNR6q4V8w',
            type: 'file',
            mountPath: '/uploads/receipt.pdf',
            betas: ['string'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsFileResource::class, $result);
    }
}
