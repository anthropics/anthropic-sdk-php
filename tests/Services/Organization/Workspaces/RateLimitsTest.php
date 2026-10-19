<?php

namespace Tests\Services\Organization\Workspaces;

use Anthropic\Client;
use Anthropic\Core\Util;
use Anthropic\Organization\Workspaces\RateLimits\WorkspaceRateLimit;
use Anthropic\Organization\Workspaces\RateLimits\WorkspaceRateLimitType;
use Anthropic\PageCursor;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
final class RateLimitsTest extends TestCase
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
    public function testUpdate(): void
    {
        $result = $this->client->organization->workspaces->rateLimits->update(
            'rate_limit_id',
            workspaceID: 'workspace_id',
            limits: [['type' => WorkspaceRateLimitType::FAST_ITPMCA, 'value' => 0]],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(WorkspaceRateLimit::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        $result = $this->client->organization->workspaces->rateLimits->update(
            'rate_limit_id',
            workspaceID: 'workspace_id',
            limits: [['type' => WorkspaceRateLimitType::FAST_ITPMCA, 'value' => 0]],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(WorkspaceRateLimit::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->organization->workspaces->rateLimits->list(
            'workspace_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(WorkspaceRateLimit::class, $item);
        }
    }
}
