#!/usr/bin/env php

<?php

/**
 * Comprehensive Managed Agents example demonstrating:
 *  - Vault and credential management
 *  - Skill creation with uploaded files
 *  - Agent creation with custom tools and agent toolset
 *  - Agent versioning (create v1, update to v2, list versions)
 *  - Session creation with vault credentials
 *  - Streaming events and handling custom tool calls
 */

require_once dirname(__DIR__, 2).'/vendor/autoload.php';

use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentCustomToolUseEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionEndTurn;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusIdleEvent;
use Anthropic\Client;
use Anthropic\Core\FileParam;

$client = new Client(
    apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key'
);

// ── Vault and credential ──────────────────────────────────────────────────────

$vault = $client->beta->vaults->create(
    displayName: 'comprehensive-example-vault'
);
echo "Created vault: {$vault->id}\n";

$credential = $client->beta->vaults->credentials->create(
    vaultID: $vault->id,
    auth: [
        'type' => 'static_bearer',
        'token' => 'example-bearer-token',
        'mcp_server_url' => 'https://mcp.example.com',
    ],
    displayName: 'Example Bearer Credential',
);
echo "Created credential: {$credential->id}\n";

// ── Skill ─────────────────────────────────────────────────────────────────────

$skillMd = "# Weather Skill\n\nRetrieves current weather for a given city.\n";
$skill = $client->skills->create(
    displayName: 'Weather Skill',
    files: [FileParam::fromString($skillMd, 'weather/SKILL.md', 'text/markdown')],
);
echo "Created skill: {$skill->id}\n";

// ── Agent v1 with custom tool and agent toolset ───────────────────────────────

$environment = $client->beta->environments->create(
    name: 'comprehensive-example-environment'
);
echo "Created environment: {$environment->id}\n";

$agent = $client->beta->agents->create(
    model: 'claude-sonnet-5',
    name: 'comprehensive-example-agent',
    system: 'You are a helpful assistant. When asked about the weather, always call the get_weather tool.',
    tools: [
        [
            'type' => 'custom',
            'name' => 'get_weather',
            'description' => 'Get the current weather for a city.',
            'input_schema' => [
                'type' => 'object',
                'properties' => [
                    'city' => ['type' => 'string', 'description' => 'The city to get weather for'],
                ],
                'required' => ['city'],
            ],
        ],
        [
            'type' => 'agent_toolset_20260401',
            'default_config' => [
                'enabled' => true,
                'permission_policy' => ['type' => 'always_allow'],
            ],
        ],
    ],
);
echo "Created agent v{$agent->version}: {$agent->id}\n";

// ── Agent v2: update to add a description ────────────────────────────────────

$agent = $client->beta->agents->update(
    agentID: $agent->id,
    version: $agent->version,
    description: 'An agent that can retrieve weather information and answer questions.',
);
echo "Updated agent to v{$agent->version}\n";

// ── List agent versions ───────────────────────────────────────────────────────

$versions = $client->beta->agents->versions->list(agentID: $agent->id);
$versionNumbers = array_map(fn ($v) => $v->version, $versions->getItems());
echo 'Agent versions: ['.implode(', ', $versionNumbers)."]\n";

// ── Session ───────────────────────────────────────────────────────────────────

$session = $client->beta->sessions->create(
    agent: ['type' => 'agent', 'id' => $agent->id, 'version' => $agent->version],
    environmentID: $environment->id,
);
echo "Created session: {$session->id}\n";

// ── Send a message and handle the custom tool call ───────────────────────────

$client->beta->sessions->events->send(
    sessionID: $session->id,
    events: [
        [
            'type' => 'user.message',
            'content' => [['type' => 'text', 'text' => "What's the weather in Paris?"]],
        ],
    ]
);

echo "Streaming events:\n";
$pendingToolUseID = null;

$stream = $client->beta->sessions->events->streamStream(sessionID: $session->id);
foreach ($stream as $event) {
    echo "  event.type={$event->type}\n";

    if ($event instanceof ManagedAgentsAgentCustomToolUseEvent) {
        $pendingToolUseID = $event->id;
        echo "  → Custom tool call: {$event->name}(".json_encode($event->input).")\n";
    }

    if ($event instanceof ManagedAgentsSessionStatusIdleEvent) {
        if ($event->stopReason instanceof ManagedAgentsSessionEndTurn) {
            echo "  → Session completed (end_turn)\n";
            break;
        }

        // Agent is waiting for a custom tool result
        if ($pendingToolUseID !== null) {
            echo "  → Sending tool result for {$pendingToolUseID}\n";
            $client->beta->sessions->events->send(
                sessionID: $session->id,
                events: [
                    [
                        'type' => 'user.custom_tool_result',
                        'custom_tool_use_id' => $pendingToolUseID,
                        'content' => [['type' => 'text', 'text' => 'Sunny, 22°C']],
                    ],
                ]
            );
            $pendingToolUseID = null;

            // Resume streaming
            $stream = $client->beta->sessions->events->streamStream(sessionID: $session->id);
        }
    }
}
