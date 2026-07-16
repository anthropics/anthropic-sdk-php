<?php

namespace Tests\Services\Beta\Tunnels;

use Anthropic\Beta\Tunnels\Certificates\TunnelCertificate;
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
final class CertificatesTest extends TestCase
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
        $result = $this->client->beta->tunnels->certificates->create(
            'tunnel_id',
            caCertificatePem: 'ca_certificate_pem'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TunnelCertificate::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->beta->tunnels->certificates->create(
            'tunnel_id',
            caCertificatePem: 'ca_certificate_pem',
            betas: ['message-batches-2024-09-24'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TunnelCertificate::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('buildURL drops path-level query params (SDK-4349)');
        }

        $result = $this->client->beta->tunnels->certificates->retrieve(
            'certificate_id',
            tunnelID: 'tunnel_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TunnelCertificate::class, $result);
    }

    #[Test]
    public function testRetrieveWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('buildURL drops path-level query params (SDK-4349)');
        }

        $result = $this->client->beta->tunnels->certificates->retrieve(
            'certificate_id',
            tunnelID: 'tunnel_id',
            betas: ['message-batches-2024-09-24'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TunnelCertificate::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('buildURL drops path-level query params (SDK-4349)');
        }

        $page = $this->client->beta->tunnels->certificates->list('tunnel_id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(TunnelCertificate::class, $item);
        }
    }

    #[Test]
    public function testArchive(): void
    {
        $result = $this->client->beta->tunnels->certificates->archive(
            'certificate_id',
            tunnelID: 'tunnel_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TunnelCertificate::class, $result);
    }

    #[Test]
    public function testArchiveWithOptionalParams(): void
    {
        $result = $this->client->beta->tunnels->certificates->archive(
            'certificate_id',
            tunnelID: 'tunnel_id',
            betas: ['message-batches-2024-09-24'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TunnelCertificate::class, $result);
    }
}
