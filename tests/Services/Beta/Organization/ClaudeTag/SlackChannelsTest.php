<?php

namespace Tests\Services\Beta\Organization\ClaudeTag;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\BetaClaudeTagDeletedSlackChannel;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\BetaClaudeTagSlackChannel;
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
final class SlackChannelsTest extends TestCase
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
        $result = $this
            ->client
            ->beta
            ->organization
            ->claudeTag
            ->slackChannels
            ->create(
                slack: ['channelID' => 'xx', 'workspaceID' => 'xx'],
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaClaudeTagSlackChannel::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->claudeTag
            ->slackChannels
            ->create(
                slack: ['channelID' => 'xx', 'workspaceID' => 'xx'],
                settings: [
                    'enabled' => true,
                    'environmentID' => 'x',
                    'guestPolicy' => ['type' => 'allow'],
                    'instructions' => 'instructions',
                    'model' => 'x',
                ],
                betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaClaudeTagSlackChannel::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->claudeTag
            ->slackChannels
            ->retrieve(
                'slch_01SvpyRQK3nN6eH9uhRA7n1q',
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaClaudeTagSlackChannel::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->claudeTag
            ->slackChannels
            ->update(
                'slch_01SvpyRQK3nN6eH9uhRA7n1q',
                settings: [],
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaClaudeTagSlackChannel::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->claudeTag
            ->slackChannels
            ->update(
                'slch_01SvpyRQK3nN6eH9uhRA7n1q',
                settings: [
                    'enabled' => true,
                    'environmentID' => 'x',
                    'guestPolicy' => ['type' => 'allow'],
                    'instructions' => 'instructions',
                    'model' => 'x',
                ],
                betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaClaudeTagSlackChannel::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->beta->organization->claudeTag->slackChannels->list(
            slackWorkspaceID: 'slack_workspace_id',
            requestOptions: ['extraQueryParams' => ['beta' => 'true']],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(BetaClaudeTagSlackChannel::class, $item);
        }
    }

    #[Test]
    public function testListWithOptionalParams(): void
    {
        $page = $this->client->beta->organization->claudeTag->slackChannels->list(
            slackWorkspaceID: 'slack_workspace_id',
            includeInherited: true,
            limit: 0,
            page: 'page',
            slackChannelID: 'slack_channel_id',
            betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
            requestOptions: ['extraQueryParams' => ['beta' => 'true']],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(BetaClaudeTagSlackChannel::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->claudeTag
            ->slackChannels
            ->delete(
                'slch_01SvpyRQK3nN6eH9uhRA7n1q',
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaClaudeTagDeletedSlackChannel::class, $result);
    }
}
