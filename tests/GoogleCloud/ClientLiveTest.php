<?php

namespace Tests\GoogleCloud;

use Anthropic\Core\Exceptions\APIStatusException;
use Anthropic\GoogleCloud\Client;
use Anthropic\Messages\Model;
use PHPUnit\Framework\TestCase;

/**
 * Live tests against a real Google Cloud gateway. Gated on ANTHROPIC_LIVE=1.
 *
 * @internal
 *
 * @coversNothing
 */
final class ClientLiveTest extends TestCase
{
    protected function setUp(): void
    {
        if ('1' !== getenv('ANTHROPIC_LIVE')) {
            $this->markTestSkipped('Set ANTHROPIC_LIVE=1 to run Google Cloud live tests');
        }
    }

    public function testMessagesCreate(): void
    {
        $message = $this->makeClient()->messages->create(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Say hi in one short sentence.']],
            model: Model::CLAUDE_HAIKU_4_5,
        );

        $this->assertNotEmpty($message->id);
        $this->assertNotEmpty($message->content);
    }

    public function testMessagesCreateStream(): void
    {
        $stream = $this->makeClient()->messages->createStream(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Count to three.']],
            model: Model::CLAUDE_HAIKU_4_5,
        );

        $events = 0;
        foreach ($stream as $event) {
            ++$events;
        }

        $this->assertGreaterThan(0, $events);
    }

    public function testTypedError(): void
    {
        $this->expectException(APIStatusException::class);

        $this->makeClient()->messages->create(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'hi']],
            model: 'this-model-does-not-exist',
        );
    }

    public function testOrganizationRoute(): void
    {
        $workspaceId = getenv('ANTHROPIC_GOOGLE_CLOUD_WORKSPACE_ID');
        if (!is_string($workspaceId)) {
            $this->markTestSkipped('Set ANTHROPIC_GOOGLE_CLOUD_WORKSPACE_ID to run this test');
        }

        $workspace = $this->makeClient()->organization->workspaces->retrieve($workspaceId);

        $this->assertSame($workspaceId, $workspace->id);
    }

    public function testManagedAgentsRoutes(): void
    {
        $client = $this->makeClient();
        $agent = $client->beta->agents->create(model: Model::CLAUDE_HAIKU_4_5->value, name: 'sdk-live-test');

        try {
            $this->assertSame($agent->id, $client->beta->agents->retrieve($agent->id)->id);
            $this->assertNotEmpty($client->beta->agents->list(limit: 1)->getItems());
        } finally {
            $archived = $client->beta->agents->archive($agent->id);
        }

        $this->assertNotNull($archived->archivedAt);
    }

    private function makeClient(): Client
    {
        return new Client;
    }
}
