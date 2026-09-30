<?php

namespace Tests\Services\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsSingleDayActivitySummary;
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
final class SummariesTest extends TestCase
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
        $page = $this->client->beta->organization->analytics->summaries->list(
            startingDate: '2019-12-27'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(AnalyticsSingleDayActivitySummary::class, $item);
        }
    }

    #[Test]
    public function testListWithOptionalParams(): void
    {
        $page = $this->client->beta->organization->analytics->summaries->list(
            startingDate: '2019-12-27',
            endingDate: '2019-12-27',
            filter: ['string'],
            limit: 1,
            page: 'page',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(AnalyticsSingleDayActivitySummary::class, $item);
        }
    }
}
