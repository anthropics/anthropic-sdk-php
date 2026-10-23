<?php

namespace Tests\Services\Beta\Organization\ClaudeTag;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ClaudeTag\SlackWorkspaces\BetaClaudeTagSlackWorkspace;
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
final class SlackWorkspacesTest extends TestCase
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
    public function testRetrieve(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->claudeTag
            ->slackWorkspaces
            ->retrieve(
                'slws_01Hq8TzW5mKc2YbX7vNd4RfJ',
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaClaudeTagSlackWorkspace::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->claudeTag
            ->slackWorkspaces
            ->update(
                'slws_01Hq8TzW5mKc2YbX7vNd4RfJ',
                settings: [],
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaClaudeTagSlackWorkspace::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->claudeTag
            ->slackWorkspaces
            ->update(
                'slws_01Hq8TzW5mKc2YbX7vNd4RfJ',
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
        $this->assertInstanceOf(BetaClaudeTagSlackWorkspace::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->beta->organization->claudeTag->slackWorkspaces->list(
            requestOptions: ['extraQueryParams' => ['beta' => 'true']]
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(BetaClaudeTagSlackWorkspace::class, $item);
        }
    }
}
