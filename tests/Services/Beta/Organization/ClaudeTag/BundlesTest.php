<?php

namespace Tests\Services\Beta\Organization\ClaudeTag;

use Anthropic\Beta\Organization\ClaudeTag\Bundles\BetaClaudeTagBundle;
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
final class BundlesTest extends TestCase
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
        $result = $this->client->beta->organization->claudeTag->bundles->retrieve(
            'capp_011CZkZjLP1cWxj5EtMmdgbq',
            requestOptions: ['extraQueryParams' => ['beta' => 'true']],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaClaudeTagBundle::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->beta->organization->claudeTag->bundles->list(
            requestOptions: ['extraQueryParams' => ['beta' => 'true']]
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(BetaClaudeTagBundle::class, $item);
        }
    }
}
