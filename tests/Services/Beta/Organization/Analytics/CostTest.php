<?php

namespace Tests\Services\Beta\Organization\Analytics;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Analytics\AnalyticsActorType;
use Anthropic\Beta\Organization\Analytics\AnalyticsClaudeTagCategory;
use Anthropic\Beta\Organization\Analytics\AnalyticsContextWindow;
use Anthropic\Beta\Organization\Analytics\AnalyticsInferenceGeoFilter;
use Anthropic\Beta\Organization\Analytics\AnalyticsServiceTier;
use Anthropic\Beta\Organization\Analytics\AnalyticsSpeed;
use Anthropic\Beta\Organization\Analytics\AnalyticsTimeBucketWidth;
use Anthropic\Beta\Organization\Analytics\AnalyticsUsageCostProductFilter;
use Anthropic\Beta\Organization\Analytics\AnalyticsUsageCostSortOrder;
use Anthropic\Beta\Organization\Analytics\Cost\BetaAnalyticsCostGroupBy;
use Anthropic\Beta\Organization\Analytics\Cost\BetaAnalyticsCostItem;
use Anthropic\Beta\Organization\Analytics\Cost\BetaAnalyticsCostOrderBy;
use Anthropic\Client;
use Anthropic\Core\Util;
use Anthropic\ReportPageCursor;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
final class CostTest extends TestCase
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
        $page = $this->client->beta->organization->analytics->cost->list(
            startingAt: new \DateTimeImmutable('2019-12-27T18:11:19.117Z')
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ReportPageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(BetaAnalyticsCostItem::class, $item);
        }
    }

    #[Test]
    public function testListWithOptionalParams(): void
    {
        $page = $this->client->beta->organization->analytics->cost->list(
            startingAt: new \DateTimeImmutable('2019-12-27T18:11:19.117Z'),
            actorIDs: ['user_01WCz1FkmYMm4gnmykNKUu3Q'],
            actorTypes: [AnalyticsActorType::SERVICE_ACCOUNT_ACTOR],
            agentIDs: ['agent_01VHd3EAGJ6PLkP9LM7DDu3f'],
            apiKeyIDs: ['apikey_01Rj2N8SVvo6BePZj99NhmiT'],
            claudeTagCategories: [AnalyticsClaudeTagCategory::ENGAGED],
            claudeTagUserIDs: ['U0123ABCDEF'],
            contextWindows: [AnalyticsContextWindow::FROM_0_TO_200K],
            deploymentIDs: ['depl_01JFC6ihzZHtAuyHsaENdJhY'],
            endingAt: new \DateTimeImmutable('2019-12-27T18:11:19.117Z'),
            environmentIDs: ['env_017oTjuGedHtjhJauVC5xGJD'],
            excludeDeletedUsers: true,
            groupBy: [BetaAnalyticsCostGroupBy::ACTOR],
            inferenceGeos: [AnalyticsInferenceGeoFilter::GLOBAL],
            limit: 1,
            models: ['string'],
            order: AnalyticsUsageCostSortOrder::ASC,
            orderBy: BetaAnalyticsCostOrderBy::AMOUNT,
            page: 'page',
            products: [AnalyticsUsageCostProductFilter::CHAT],
            rbacGroupIDs: ['rbac_group_012rppKaSVsmTo6NqRDXQXNF'],
            serviceTiers: [AnalyticsServiceTier::BATCH],
            sessionIDs: ['sesn_0187kPDyNCwibNNvfaPEApCJ'],
            slackChannelIDs: ['C0123ABCDEF'],
            speeds: [AnalyticsSpeed::FAST],
            timeBucketWidth: AnalyticsTimeBucketWidth::DAY,
            userProfileIDs: ['uprof_01M33NeYUQK2WV9PpYcsPHLi'],
            workspaceIDs: ['wrkspc_01JwQvzr7rXLA5AGx3HKfFUJ'],
            betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ReportPageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(BetaAnalyticsCostItem::class, $item);
        }
    }
}
