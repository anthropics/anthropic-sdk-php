<?php

namespace Tests\Services\Skills;

use Anthropic\Client;
use Anthropic\Core\FileParam;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\Skills\Versions\DeletedSkillVersion;
use Anthropic\Skills\Versions\SkillVersion;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
final class VersionsTest extends TestCase
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
        $result = $this->client->skills->versions->create(
            'skill_id',
            files: [
                FileParam::fromString('Example data', filename: uniqid('file-upload-', true)),
            ],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SkillVersion::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->skills->versions->create(
            'skill_id',
            files: [
                FileParam::fromString('Example data', filename: uniqid('file-upload-', true)),
            ],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SkillVersion::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->skills->versions->retrieve(
            'version',
            skillID: 'skill_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SkillVersion::class, $result);
    }

    #[Test]
    public function testRetrieveWithOptionalParams(): void
    {
        $result = $this->client->skills->versions->retrieve(
            'version',
            skillID: 'skill_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SkillVersion::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->skills->versions->list('skill_id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(SkillVersion::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->skills->versions->delete(
            'version',
            skillID: 'skill_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DeletedSkillVersion::class, $result);
    }

    #[Test]
    public function testDeleteWithOptionalParams(): void
    {
        $result = $this->client->skills->versions->delete(
            'version',
            skillID: 'skill_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DeletedSkillVersion::class, $result);
    }
}
