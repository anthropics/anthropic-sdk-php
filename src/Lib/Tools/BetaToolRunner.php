<?php

declare(strict_types=1);

namespace Anthropic\Lib\Tools;

use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Beta\Messages\BetaMessageParam;
use Anthropic\Beta\Messages\BetaToolUseBlock;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Model;

/**
 * Handles the automatic conversation loop between the assistant and tools.
 *
 * BetaToolRunner is an iterable that yields each BetaMessage produced during
 * the tool execution loop. The loop continues until the model stops requesting
 * tools or max_iterations is reached.
 *
 * @phpstan-import-type BetaToolUnionShape from \Anthropic\Beta\Messages\BetaToolUnion
 *
 * @implements \IteratorAggregate<int, BetaMessage>
 */
final class BetaToolRunner implements \IteratorAggregate
{
    private bool $consumed = false;

    /**
     * Set to true when setMessagesParams() or pushMessages() is called during
     * iteration, signalling that the caller is managing history manually and
     * the runner should skip auto-appending the current assistant message.
     */
    private bool $mutated = false;

    /** @var list<BetaRunnableTool|BetaToolUnionShape> Original tools array (runnable + plain defs) */
    private array $tools;

    /** @var array<string, BetaRunnableTool> For quick lookup during tool execution */
    private array $runnableToolsByName = [];

    /** @var list<array<string, mixed>> API tool definitions extracted from $tools */
    private array $toolDefinitions = [];

    /** @var list<array<string, mixed>> Growing message history */
    private array $messages;

    private string $model;

    /**
     * @param list<BetaRunnableTool|BetaToolUnionShape> $tools Mix of runnable tools and plain tool definitions
     * @param list<array<string, mixed>> $messages Initial messages
     * @param array<string, mixed> $extraParams Additional params forwarded to every messages.create() call
     */
    public function __construct(
        private Client $client,
        private int $maxTokens,
        array $messages,
        Model|string $model,
        array $tools = [],
        private ?int $maxIterations = null,
        private array $extraParams = [],
    ) {
        $this->model = $model instanceof Model ? $model->value : $model;
        $this->messages = $messages;
        $this->tools = $tools;
        $this->processTools($tools);
    }

    /**
     * Iterate over each BetaMessage produced during the tool loop.
     *
     * @throws \RuntimeException If the runner has already been consumed
     *
     * @return \Generator<int, BetaMessage>
     */
    public function getIterator(): \Generator
    {
        return $this->doIterate();
    }

    /**
     * Run the full loop and return the final BetaMessage.
     *
     * @throws \RuntimeException If the loop produces no messages
     */
    public function runUntilDone(): BetaMessage
    {
        $last = null;
        foreach ($this as $message) {
            $last = $message;
        }

        if (null === $last) {
            throw new \RuntimeException('ToolRunner concluded without a message from the server');
        }

        return $last;
    }

    /**
     * Update the parameters used for subsequent API calls.
     *
     * Accepts either a full replacement array or a mutator callable that receives
     * the current params and returns new params. Recognized keys match the named
     * parameters of MessagesService::create() (camelCase), plus `maxIterations`.
     *
     * Calling this during iteration signals that the caller is managing message
     * history manually; the runner will skip auto-appending the current assistant
     * message for that turn.
     *
     * @param array<string, mixed>|callable(array<string, mixed>): array<string, mixed> $paramsOrMutator
     */
    public function setMessagesParams(array|callable $paramsOrMutator): void
    {
        $new = is_array($paramsOrMutator)
            ? $paramsOrMutator
            : $paramsOrMutator($this->getParams());

        if (is_int($new['maxTokens'] ?? null)) {
            $this->maxTokens = $new['maxTokens'];
        }

        if (is_string($new['model'] ?? null)) {
            $this->model = $new['model'];
        }

        if (array_key_exists('maxIterations', $new)) {
            $this->maxIterations = is_int($new['maxIterations']) ? $new['maxIterations'] : null;
        }

        if (is_array($new['messages'] ?? null)) {
            /** @var list<array<string, mixed>> $messages */
            $messages = array_map(
                fn ($msg) => $msg instanceof BaseModel ? $msg->jsonSerialize() : $msg,
                $new['messages'],
            );
            $this->messages = $messages;
        }

        if (is_array($new['tools'] ?? null)) {
            /** @var list<BetaRunnableTool|BetaToolUnionShape> $tools */
            $tools = $new['tools'];
            $this->tools = $tools;
            $this->runnableToolsByName = [];
            $this->toolDefinitions = [];
            $this->processTools($tools);
        }

        $knownKeys = ['maxTokens', 'model', 'maxIterations', 'messages', 'tools'];

        /** @var array<string, mixed> $extra */
        $extra = array_diff_key($new, array_flip($knownKeys));
        if ([] !== $extra) {
            $this->extraParams = array_merge($this->extraParams, $extra);
        }

        $this->mutated = true;
    }

    /**
     * Append one or more messages to the current history.
     *
     * Like setMessagesParams(), calling this during iteration signals manual
     * history management for that turn.
     *
     * @param array<string, mixed>|BetaMessageParam|BetaMessage ...$messages
     */
    public function pushMessages(array|BaseModel ...$messages): void
    {
        /** @var list<array<string, mixed>> $normalized */
        $normalized = array_map(
            fn ($msg) => $msg instanceof BaseModel ? $msg->jsonSerialize() : $msg,
            $messages,
        );
        array_push($this->messages, ...$normalized);
        $this->mutated = true;
    }

    /**
     * Returns a read-only snapshot of the current params.
     *
     * The returned array uses the same camelCase keys accepted by setMessagesParams().
     *
     * @return array<string, mixed>
     */
    public function getParams(): array
    {
        return array_filter(
            array_merge(
                [
                    'maxTokens' => $this->maxTokens,
                    'messages' => $this->messages,
                    'model' => $this->model,
                    'tools' => $this->tools ?: null,
                    'maxIterations' => $this->maxIterations,
                ],
                $this->extraParams,
            ),
            fn ($v) => null !== $v,
        );
    }

    // -------------------------------------------------------------------------
    // Internals
    // -------------------------------------------------------------------------

    /** @return \Generator<int, BetaMessage> */
    private function doIterate(): \Generator
    {
        if ($this->consumed) {
            throw new \RuntimeException('Cannot iterate over a consumed runner');
        }

        $this->consumed = true;

        $iterationCount = 0;

        while (true) {
            if (null !== $this->maxIterations && $iterationCount >= $this->maxIterations) {
                break;
            }

            $this->mutated = false;
            ++$iterationCount;

            $params = array_filter(
                array_merge(
                    [
                        'maxTokens' => $this->maxTokens,
                        'messages' => $this->messages,
                        'model' => $this->model,
                        'tools' => $this->toolDefinitions ?: null,
                    ],
                    $this->extraParams,
                ),
                fn ($v) => null !== $v,
            );

            // @phpstan-ignore argument.type
            $message = $this->client->beta->messages->create(...$params);

            yield $message;

            // If the caller mutated params during this yield, skip auto-appending
            // the assistant message — they are managing history manually this turn.
            // @phpstan-ignore booleanNot.alwaysTrue
            if (!$this->mutated) {
                $this->messages[] = ['role' => 'assistant', 'content' => $message->content];
            }

            $toolResults = $this->buildToolResults($this->messages[array_key_last($this->messages)]);

            if (null !== $toolResults) {
                $this->messages[] = ['role' => 'user', 'content' => $toolResults];
            } elseif (!$this->mutated) {
                break;
            }
        }
    }

    /**
     * @param array<string, mixed> $lastMessage
     *
     * @return list<array<string, mixed>>|null Tool result blocks, or null if no tool use in the message
     */
    private function buildToolResults(array $lastMessage): ?array
    {
        if (($lastMessage['role'] ?? null) !== 'assistant') {
            return null;
        }

        $content = $lastMessage['content'] ?? [];
        if (!is_array($content)) {
            return null;
        }

        $toolUseBlocks = array_values(array_filter(
            $content,
            fn ($block) => $block instanceof BetaToolUseBlock,
        ));

        if ([] === $toolUseBlocks) {
            return null;
        }

        return array_map(fn ($toolUse) => $this->executeToolUse($toolUse), $toolUseBlocks);
    }

    /**
     * @return array<string, mixed>
     */
    private function executeToolUse(BetaToolUseBlock $toolUse): array
    {
        $tool = $this->runnableToolsByName[$toolUse->name] ?? null;

        if (null === $tool) {
            return [
                'type' => 'tool_result',
                'tool_use_id' => $toolUse->id,
                'content' => "Error: Tool '{$toolUse->name}' not found",
                'is_error' => true,
            ];
        }

        try {
            return [
                'type' => 'tool_result',
                'tool_use_id' => $toolUse->id,
                'content' => $tool->run($toolUse->input),
            ];
        } catch (\Throwable $e) {
            return [
                'type' => 'tool_result',
                'tool_use_id' => $toolUse->id,
                'content' => 'Error: '.$e->getMessage(),
                'is_error' => true,
            ];
        }
    }

    /**
     * @param list<BetaRunnableTool|BetaToolUnionShape> $tools
     */
    private function processTools(array $tools): void
    {
        foreach ($tools as $tool) {
            if ($tool instanceof BetaRunnableTool) {
                $this->runnableToolsByName[$tool->name()] = $tool;
                $def = $tool->definition;

                /** @var array<string, mixed> $serialized */
                $serialized = $def instanceof \JsonSerializable ? $def->jsonSerialize() : $def;
                $this->toolDefinitions[] = $serialized;
            } elseif ($tool instanceof \JsonSerializable) {
                // BaseModel instances (BetaTool, BetaToolBash*, etc.) — serialize for the API
                /** @var array<string, mixed> $serialized */
                $serialized = $tool->jsonSerialize();
                $this->toolDefinitions[] = $serialized;
            } else {
                $this->toolDefinitions[] = $tool;
            }
        }
    }
}
