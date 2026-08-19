<?php

namespace Tests\Services\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Files\BetaDeletedFile;
use Anthropic\Beta\Files\BetaFileMetadata;
use Anthropic\Client;
use Anthropic\Core\FileParam;
use Anthropic\Core\Util;
use Anthropic\Page;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

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

        $testUrl = Util::getenv('TEST_API_BASE_URL') ?: 'http://127.0.0.1:4010';
        $client = new Client(apiKey: 'my-anthropic-api-key', baseUrl: $testUrl);

        $this->client = $client;
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->beta->files->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Page::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(BetaFileMetadata::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->beta->files->delete('file_id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaDeletedFile::class, $result);
    }

    #[Test]
    public function testDownload(): void
    {
        $result = $this->client->beta->files->download('file_id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertIsString($result);
    }

    #[Test]
    public function testRetrieveMetadata(): void
    {
        $result = $this->client->beta->files->retrieveMetadata('file_id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaFileMetadata::class, $result);
    }

    #[Test]
    public function testUpload(): void
    {
        $result = $this->client->beta->files->upload(
            file: FileParam::fromString('Example data', filename: uniqid('file-upload-', true)),
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaFileMetadata::class, $result);
    }

    #[Test]
    public function testUploadWithOptionalParams(): void
    {
        $result = $this->client->beta->files->upload(
            file: FileParam::fromString('Example data', filename: uniqid('file-upload-', true)),
            betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaFileMetadata::class, $result);
    }
}
