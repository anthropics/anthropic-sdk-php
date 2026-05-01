<?php

declare(strict_types=1);

namespace Anthropic\Lib\Tools;

use Mcp\Client;

/**
 * @internal Invokable adapter produced by {@see BetaMcp::tool()} and handed to
 * {@see BetaRunnableTool} as its `$run` callback. Kept as a named class so the
 * `$input` parameter can carry a typed PhpDoc that the surrounding closure form
 * cannot express.
 */
final class BetaMcpToolInvoker
{
    public function __construct(
        private readonly string $name,
        private readonly Client $client,
    ) {}

    /**
     * @param array<string, mixed> $input
     *
     * @return string|list<array<string, mixed>>
     */
    public function __invoke(array $input): string|array
    {
        return BetaMcp::convertToolResult($this->client->callTool($this->name, $input));
    }
}
