<?php

namespace Tests\Services\Beta\Skills;

use Anthropic\Beta\Skills\Versions\VersionDeleteResponse;
use Anthropic\Beta\Skills\Versions\VersionGetResponse;
use Anthropic\Beta\Skills\Versions\VersionListResponse;
use Anthropic\Beta\Skills\Versions\VersionNewResponse;
use Anthropic\Client;
use Anthropic\PageCursor;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;

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

        $testUrl = getenv('TEST_API_BASE_URL') ?: 'http://127.0.0.1:4010';
        $client = new Client(apiKey: 'my-anthropic-api-key', baseUrl: $testUrl);

        $this->client = $client;
    }

    #[Test]
    public function testCreate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('prism binary unsupported');
        }

        $result = $this->client->beta->skills->versions->create('skill_id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(VersionNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->beta->skills->versions->retrieve(
            'version',
            skillID: 'skill_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(VersionGetResponse::class, $result);
    }

    #[Test]
    public function testRetrieveWithOptionalParams(): void
    {
        $result = $this->client->beta->skills->versions->retrieve(
            'version',
            skillID: 'skill_id',
            betas: ['string']
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(VersionGetResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->beta->skills->versions->list('skill_id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(VersionListResponse::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->beta->skills->versions->delete(
            'version',
            skillID: 'skill_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(VersionDeleteResponse::class, $result);
    }

    #[Test]
    public function testDeleteWithOptionalParams(): void
    {
        $result = $this->client->beta->skills->versions->delete(
            'version',
            skillID: 'skill_id',
            betas: ['string']
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(VersionDeleteResponse::class, $result);
    }
}
