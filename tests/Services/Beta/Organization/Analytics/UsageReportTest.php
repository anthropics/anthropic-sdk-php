<?php

namespace Tests\Services\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsClaudeTagCategory;
use Anthropic\Beta\Organization\Analytics\AnalyticsContextWindow;
use Anthropic\Beta\Organization\Analytics\AnalyticsInferenceGeoFilter;
use Anthropic\Beta\Organization\Analytics\AnalyticsProductFilter;
use Anthropic\Beta\Organization\Analytics\AnalyticsUsageReportTimeBucket;
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
final class UsageReportTest extends TestCase
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
        $page = $this->client->beta->organization->analytics->usageReport->list(
            startingAt: new \DateTimeImmutable('2019-12-27T18:11:19.117Z')
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(AnalyticsUsageReportTimeBucket::class, $item);
        }
    }

    #[Test]
    public function testListWithOptionalParams(): void
    {
        $page = $this->client->beta->organization->analytics->usageReport->list(
            startingAt: new \DateTimeImmutable('2019-12-27T18:11:19.117Z'),
            bucketWidth: '1d',
            claudeTagCategories: [AnalyticsClaudeTagCategory::ENGAGED],
            claudeTagUserIDs: ['U0123ABCDEF'],
            contextWindows: [AnalyticsContextWindow::FROM_0_TO_200K],
            endingAt: new \DateTimeImmutable('2019-12-27T18:11:19.117Z'),
            groupBy: ['claude_tag_category'],
            inferenceGeos: [AnalyticsInferenceGeoFilter::GLOBAL],
            limit: 1,
            models: ['string'],
            page: 'page',
            products: [AnalyticsProductFilter::CHAT],
            rbacGroupIDs: ['rbac_group_012rppKaSVsmTo6NqRDXQXNF'],
            slackChannelIDs: ['C0123ABCDEF'],
            speeds: ['fast'],
            userIDs: ['string'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(AnalyticsUsageReportTimeBucket::class, $item);
        }
    }
}
