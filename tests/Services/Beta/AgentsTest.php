<?php

namespace Tests\Services\Beta;

use Anthropic\Beta\Agents\BetaManagedAgentsAgent;
use Anthropic\Beta\Agents\BetaManagedAgentsModel;
use Anthropic\Beta\AnthropicBeta;
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
final class AgentsTest extends TestCase
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
        $result = $this->client->beta->agents->create(
            model: BetaManagedAgentsModel::CLAUDE_OPUS_5,
            name: 'My First Agent'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsAgent::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->beta->agents->create(
            model: BetaManagedAgentsModel::CLAUDE_OPUS_5,
            name: 'My First Agent',
            description: 'A general-purpose starter agent.',
            mcpServers: [
                [
                    'name' => 'example-mcp',
                    'type' => 'url',
                    'url' => 'https://example-server.modelcontextprotocol.io/sse',
                ],
            ],
            metadata: ['foo' => 'bar'],
            multiagent: [
                'agents' => ['agent_011CZkYqphY8vELVzwCUpqiQ', ['type' => 'self']],
                'type' => 'coordinator',
            ],
            skills: [['skillID' => 'xlsx', 'type' => 'anthropic', 'version' => '1']],
            system: 'You are a general-purpose agent that can research, write code, run commands, and use connected tools to complete the user\'s task end to end.',
            tools: [
                [
                    'type' => 'agent_toolset_20260401',
                    'configs' => [
                        [
                            'name' => 'bash',
                            'enabled' => true,
                            'permissionPolicy' => ['type' => 'always_allow'],
                            'type' => 'bash',
                        ],
                    ],
                    'defaultConfig' => [
                        'enabled' => true, 'permissionPolicy' => ['type' => 'always_allow'],
                    ],
                ],
            ],
            betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsAgent::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('buildURL drops path-level query params (SDK-4349)');
        }

        $result = $this->client->beta->agents->retrieve(
            'agent_011CZkYpogX7uDKUyvBTophP'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsAgent::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->beta->agents->update(
            'agent_011CZkYpogX7uDKUyvBTophP'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsAgent::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('buildURL drops path-level query params (SDK-4349)');
        }

        $page = $this->client->beta->agents->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(BetaManagedAgentsAgent::class, $item);
        }
    }

    #[Test]
    public function testArchive(): void
    {
        $result = $this->client->beta->agents->archive(
            'agent_011CZkYpogX7uDKUyvBTophP'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsAgent::class, $result);
    }
}
