<?php

namespace Tests\Services\Beta\Sessions\Threads;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Client;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
final class EventsTest extends TestCase
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
        $page = $this->client->beta->sessions->threads->events->list(
            'sthr_011CZkZVWa6oJjw1rgXZpnBt',
            sessionID: 'sesn_011CZkZAtmR3yMPDzynEDxu7',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertNotNull($item);
        }
    }

    #[Test]
    public function testListWithOptionalParams(): void
    {
        $page = $this->client->beta->sessions->threads->events->list(
            'sthr_011CZkZVWa6oJjw1rgXZpnBt',
            sessionID: 'sesn_011CZkZAtmR3yMPDzynEDxu7',
            limit: 0,
            page: 'page',
            betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
            workspaceID: 'wrkspc_011CZkZaBF1tNoB5wlCeusgy',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertNotNull($item);
        }
    }
}
