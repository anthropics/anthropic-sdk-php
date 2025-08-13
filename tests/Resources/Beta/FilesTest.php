<?php

namespace Tests\Resources\Beta;

use Anthropic\Beta\Files\FileDeleteParams;
use Anthropic\Beta\Files\FileDownloadParams;
use Anthropic\Beta\Files\FileListParams;
use Anthropic\Beta\Files\FileRetrieveMetadataParams;
use Anthropic\Beta\Files\FileUploadParams;
use Anthropic\Client;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;

/**
 * @internal
 */
#[CoversNothing]
final class FilesTest extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $testUrl = getenv('TEST_API_BASE_URL') ?: 'http://127.0.0.1:4010';
        $client = new Client(apiKey: 'my-anthropic-api-key', baseUrl: $testUrl);

        $this->client = $client;
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('skipped: currently unsupported');
        }

        $params = (new FileListParams);
        $result = $this->client->beta->files->list($params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testDelete(): void
    {
        $params = (new FileDeleteParams);
        $result = $this->client->beta->files->delete('file_id', $params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testDownload(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped("Prism doesn't support application/binary responses");
        }

        $params = (new FileDownloadParams);
        $result = $this->client->beta->files->download('file_id', $params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testRetrieveMetadata(): void
    {
        $params = (new FileRetrieveMetadataParams);
        $result = $this->client->beta->files->retrieveMetadata('file_id', $params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testUpload(): void
    {
        $params = FileUploadParams::with(file: 'file');
        $result = $this->client->beta->files->upload($params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testUploadWithOptionalParams(): void
    {
        $params = FileUploadParams::with(file: 'file', anthropicBeta: ['string']);
        $result = $this->client->beta->files->upload($params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }
}
