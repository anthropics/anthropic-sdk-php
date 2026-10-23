<?php

namespace Tests\Services\Beta\Organization\ClaudeTag\Bundles;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagDeletedBundleTarget;
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
final class TargetsTest extends TestCase
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
            ->bundles
            ->targets
            ->create(
                'capp_011CZkZjLP1cWxj5EtMmdgbq',
                target: ['slackChannelID' => 'xxxxxxxx', 'type' => 'slack_channel'],
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNotNull($result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->claudeTag
            ->bundles
            ->targets
            ->create(
                'capp_011CZkZjLP1cWxj5EtMmdgbq',
                target: ['slackChannelID' => 'xxxxxxxx', 'type' => 'slack_channel'],
                betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNotNull($result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->claudeTag
            ->bundles
            ->targets
            ->retrieve(
                'btgt_01SvpyRQK3nN6eH9uhRA7n1qHq8TzW5mKc2YbX7vNd4RfJ',
                bundleID: 'capp_011CZkZjLP1cWxj5EtMmdgbq',
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNotNull($result);
    }

    #[Test]
    public function testRetrieveWithOptionalParams(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->claudeTag
            ->bundles
            ->targets
            ->retrieve(
                'btgt_01SvpyRQK3nN6eH9uhRA7n1qHq8TzW5mKc2YbX7vNd4RfJ',
                bundleID: 'capp_011CZkZjLP1cWxj5EtMmdgbq',
                betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNotNull($result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this
            ->client
            ->beta
            ->organization
            ->claudeTag
            ->bundles
            ->targets
            ->list(
                'capp_011CZkZjLP1cWxj5EtMmdgbq',
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertNotNull($item);
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
            ->bundles
            ->targets
            ->delete(
                'btgt_01SvpyRQK3nN6eH9uhRA7n1qHq8TzW5mKc2YbX7vNd4RfJ',
                bundleID: 'capp_011CZkZjLP1cWxj5EtMmdgbq',
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaClaudeTagDeletedBundleTarget::class, $result);
    }

    #[Test]
    public function testDeleteWithOptionalParams(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->claudeTag
            ->bundles
            ->targets
            ->delete(
                'btgt_01SvpyRQK3nN6eH9uhRA7n1qHq8TzW5mKc2YbX7vNd4RfJ',
                bundleID: 'capp_011CZkZjLP1cWxj5EtMmdgbq',
                betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaClaudeTagDeletedBundleTarget::class, $result);
    }
}
