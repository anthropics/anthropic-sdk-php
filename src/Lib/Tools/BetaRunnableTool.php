<?php

declare(strict_types=1);

namespace Anthropic\Lib\Tools;

use Anthropic\Beta\Messages\BetaMemoryTool20250818;
use Anthropic\Beta\Messages\BetaTool;
use Anthropic\Beta\Messages\BetaToolBash20241022;
use Anthropic\Beta\Messages\BetaToolBash20250124;
use Anthropic\Beta\Messages\BetaToolComputerUse20241022;
use Anthropic\Beta\Messages\BetaToolComputerUse20250124;
use Anthropic\Beta\Messages\BetaToolComputerUse20251124;
use Anthropic\Beta\Messages\BetaToolTextEditor20241022;
use Anthropic\Beta\Messages\BetaToolTextEditor20250124;
use Anthropic\Beta\Messages\BetaToolTextEditor20250429;
use Anthropic\Beta\Messages\BetaToolTextEditor20250728;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A client-side runnable tool that pairs a tool definition with an execution callback.
 *
 * The definition can be any client-runnable tool type — e.g. {@see BetaTool},
 * {@see BetaToolBash20241022}, {@see BetaToolBash20250124},
 * {@see BetaMemoryTool20250818},
 * {@see BetaToolComputerUse20241022},
 * {@see BetaToolComputerUse20250124},
 * {@see BetaToolComputerUse20251124},
 * {@see BetaToolTextEditor20241022},
 * {@see BetaToolTextEditor20250124},
 * {@see BetaToolTextEditor20250429},
 * {@see BetaToolTextEditor20250728},
 * or a plain array tool definition.
 */
final class BetaRunnableTool
{
    /**
     * @param BaseModel|array<string, mixed> $definition  One of the client-runnable tool types or a plain array
     * @param \Closure(array<string, mixed>): (string|list<array<string, mixed>>) $run  Executed when the model calls this tool
     */
    public function __construct(
        public readonly BaseModel|array $definition,
        private readonly \Closure $run,
    ) {}

    /**
     * Execute the tool with the given input.
     *
     * @param array<string, mixed> $input
     *
     * @return string|list<array<string, mixed>>
     */
    public function run(array $input): string|array
    {
        return ($this->run)($input);
    }

    /**
     * The tool name, extracted from the definition.
     */
    public function name(): string
    {
        $name = $this->definition['name'] ?? null;

        if (!is_string($name)) {
            throw new \RuntimeException('Tool definition must have a string "name" field');
        }

        return $name;
    }
}
