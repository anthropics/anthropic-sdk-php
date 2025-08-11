<?php

namespace Tests\Resources\Beta;

use Anthropic\Client;
use Anthropic\Models\Beta\FileDeleteParams;
use Anthropic\Models\Beta\FileDownloadParams;
use Anthropic\Models\Beta\FileListParams;
use Anthropic\Models\Beta\FileRetrieveMetadataParams;
use Anthropic\Models\Beta\FileUploadParams;
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

        $result = $this->client->beta->files->list(new FileListParams);

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this
            ->client
            ->beta
            ->files
            ->delete('file_id', new FileDeleteParams)
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testDownload(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped("Prism doesn't support application/binary responses");
        }

        $result = $this
            ->client
            ->beta
            ->files
            ->download('file_id', new FileDownloadParams)
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testRetrieveMetadata(): void
    {
        $result = $this
            ->client
            ->beta
            ->files
            ->retrieveMetadata('file_id', new FileRetrieveMetadataParams)
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testUpload(): void
    {
        $result = $this
            ->client
            ->beta
            ->files
            ->upload(FileUploadParams::new(file: 'file'))
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testUploadWithOptionalParams(): void
    {
        $result = $this
            ->client
            ->beta
            ->files
            ->upload(FileUploadParams::new(file: 'file', anthropicBeta: ['string']))
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }
}
