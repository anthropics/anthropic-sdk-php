<?php

namespace Tests\Services;

use Anthropic\Client;
use Anthropic\Core\FileParam;
use Anthropic\Core\Util;
use Anthropic\Files\DeletedFile;
use Anthropic\Files\FileMetadata;
use Anthropic\PageCursor;
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
        $page = $this->client->files->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(FileMetadata::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->files->delete('file_id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DeletedFile::class, $result);
    }

    #[Test]
    public function testDownload(): void
    {
        $result = $this->client->files->download('file_id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertIsString($result);
    }

    #[Test]
    public function testRetrieveMetadata(): void
    {
        $result = $this->client->files->retrieveMetadata('file_id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FileMetadata::class, $result);
    }

    #[Test]
    public function testUpload(): void
    {
        $result = $this->client->files->upload(
            file: FileParam::fromString('Example data', filename: uniqid('file-upload-', true)),
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FileMetadata::class, $result);
    }

    #[Test]
    public function testUploadWithOptionalParams(): void
    {
        $result = $this->client->files->upload(
            file: FileParam::fromString('Example data', filename: uniqid('file-upload-', true)),
            expiresInSeconds: 3600,
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FileMetadata::class, $result);
    }
}
