<?php

namespace Tests\Services\Beta\Sessions;

use Anthropic\Beta\Sessions\Events\ManagedAgentsSendSessionEvents;
use Anthropic\Client;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;

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
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('buildURL drops path-level query params (SDK-4349)');
        }

        $page = $this->client->beta->sessions->events->list(
            'sesn_011CZkZAtmR3yMPDzynEDxu7'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertNotNull($item);
        }
    }

    #[Test]
    public function testSend(): void
    {
        $result = $this->client->beta->sessions->events->send(
            'sesn_011CZkZAtmR3yMPDzynEDxu7',
            events: [
                [
                    'content' => [
                        ['text' => 'Where is my order #1234?', 'type' => 'text'],
                    ],
                    'type' => 'user.message',
                ],
            ],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsSendSessionEvents::class, $result);
    }

    #[Test]
    public function testSendWithOptionalParams(): void
    {
        $result = $this->client->beta->sessions->events->send(
            'sesn_011CZkZAtmR3yMPDzynEDxu7',
            events: [
                [
                    'content' => [
                        ['text' => 'Where is my order #1234?', 'type' => 'text'],
                    ],
                    'type' => 'user.message',
                ],
            ],
            betas: ['string'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ManagedAgentsSendSessionEvents::class, $result);
    }
}
