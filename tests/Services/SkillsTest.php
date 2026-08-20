<?php

namespace Tests\Services;

use Anthropic\Client;
use Anthropic\Core\FileParam;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\Skills\DeletedSkill;
use Anthropic\Skills\Skill;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
final class SkillsTest extends TestCase
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
        $result = $this->client->skills->create(
            files: [
                FileParam::fromString('Example data', filename: uniqid('file-upload-', true)),
            ],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Skill::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->skills->create(
            files: [
                FileParam::fromString('Example data', filename: uniqid('file-upload-', true)),
            ],
            displayName: 'display_name',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Skill::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->skills->retrieve('skill_id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Skill::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->skills->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(Skill::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->skills->delete('skill_id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DeletedSkill::class, $result);
    }
}
