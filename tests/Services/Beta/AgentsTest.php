<?php

namespace Tests\Services\Beta;

use Anthropic\Beta\Agents\BetaManagedAgentsAgent;
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
            model: 'claude-sonnet-4-6',
            name: 'My First Agent'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsAgent::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->beta->agents->create(
            model: 'claude-sonnet-4-6',
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
                        ],
                    ],
                    'defaultConfig' => [
                        'enabled' => true, 'permissionPolicy' => ['type' => 'always_allow'],
                    ],
                ],
            ],
            betas: ['string'],
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
            'agent_011CZkYpogX7uDKUyvBTophP',
            version: 1
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaManagedAgentsAgent::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        $result = $this->client->beta->agents->update(
            'agent_011CZkYpogX7uDKUyvBTophP',
            version: 1,
            description: 'description',
            mcpServers: [
                [
                    'name' => 'example-mcp',
                    'type' => 'url',
                    'url' => 'https://example-server.modelcontextprotocol.io/sse',
                ],
            ],
            metadata: ['foo' => 'string'],
            model: 'claude-opus-4-6',
            name: 'name',
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
                        ],
                    ],
                    'defaultConfig' => [
                        'enabled' => true, 'permissionPolicy' => ['type' => 'always_allow'],
                    ],
                ],
            ],
            betas: ['string'],
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
