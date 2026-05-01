#!/usr/bin/env php

<?php

/**
 * Example: use the BetaMcp helpers to bridge GitHub's hosted MCP server
 * with the Anthropic SDK's beta tool runner.
 *
 * This connects to `https://api.githubcopilot.com/mcp/` over MCP's
 * Streamable HTTP transport using the official `mcp/sdk` (>=0.5) client,
 * lists available tools, and lets Claude invoke them to answer a question
 * about GitHub issues.
 *
 * Requirements:
 *   - GITHUB_TOKEN env var (a GitHub PAT with at least `public_repo` scope)
 *   - ANTHROPIC_API_KEY env var
 *   - The `mcp/sdk` package (in `require-dev`; already installed via bootstrap)
 */

require_once dirname(__DIR__, 2).'/vendor/autoload.php';

use Anthropic\Client as Anthropic;
use Anthropic\Lib\Tools\BetaMcp;
use Mcp\Client;
use Mcp\Client\Transport\HttpTransport;

$githubToken = getenv('GITHUB_TOKEN');
if (false === $githubToken || '' === $githubToken) {
    fwrite(STDERR, "GITHUB_TOKEN env var is required.\n");

    exit(1);
}

// --- Connect to GitHub's hosted MCP server ---

$mcp = Client::builder()->build();
$mcp->connect(new HttpTransport(
    endpoint: 'https://api.githubcopilot.com/mcp/',
    headers: ['Authorization' => "Bearer {$githubToken}"],
));

$tools = $mcp->listTools()->tools;
printf("Fetched %d tools from GitHub MCP server.\n\n", count($tools));

// --- Wire tools into the Anthropic beta tool runner ---

$anthropic = new Anthropic(
    apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key',
);

$question = 'List the 5 most recently opened issues in the github/github-mcp-server '
    .'repository. For each, include the issue number, title, and who opened it.';
printf("[user]: %s\n\n", $question);

$runner = $anthropic->beta->messages->toolRunner(
    maxTokens: 4096,
    messages: [['role' => 'user', 'content' => $question]],
    model: 'claude-opus-4-7',
    tools: BetaMcp::tools($tools, $mcp),
    maxIterations: 10,
);

foreach ($runner as $message) {
    foreach ($message->content as $block) {
        if ('text' === $block->type && '' !== $block->text) {
            echo $block->text."\n";
        } elseif ('tool_use' === $block->type) {
            printf("  [tool call: %s]\n", $block->name);
        }
    }
}

$mcp->disconnect();
