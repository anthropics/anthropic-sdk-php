<?php

declare(strict_types=1);

namespace Anthropic\Lib\Tools;

use Anthropic\Beta\Messages\BetaCompactionConfig;
use Anthropic\Beta\Messages\BetaContainerParams;
use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Beta\Messages\BetaMessageParam;
use Anthropic\Beta\Messages\BetaStopReason;
use Anthropic\Beta\Messages\BetaToolUseBlock;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Lib\Helpers\StainlessHelperHeader;
use Anthropic\Messages\Model;

/**
 * Handles the automatic conversation loop between the assistant and tools.
 *
 * BetaToolRunner is an iterable that yields each BetaMessage produced during
 * the tool execution loop. The loop continues until the model stops requesting
 * tools or max_iterations is reached.
 *
 * @phpstan-import-type BetaToolUnionShape from \Anthropic\Beta\Messages\BetaToolUnion
 * @phpstan-import-type BetaCompactionConfigShape from \Anthropic\Beta\Messages\BetaCompactionConfig
 *
 * @implements \IteratorAggregate<int, BetaMessage>
 */
final class BetaToolRunner implements \IteratorAggregate
{
    /** Execute the turn's client tool calls, answer with their results, and continue; with none, stop. */
    private const STEP_RUN_TOOLS = 'run_tools';

    /** The turn is unfinished: send it back unchanged, executing nothing, so the server continues it. */
    private const STEP_RESUME = 'resume';

    /** The turn is final: the loop ends on it and its tool_use blocks are not executed. */
    private const STEP_STOP = 'stop';

    private const MESSAGES_LOCKED = "Message params can't be changed while the conversation is being compacted, "
        .'because the compaction response replaces them. Make the change on the next iteration.';

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

    /** @var list<array{add: BetaRunnableTool|BaseModel|array<string, mixed>}|array{remove: string}> A runnable tool or a plain definition to add, or the name of a tool to remove */
    private array $pendingToolChanges = [];

    /** @var BetaCompactionConfig|BetaCompactionConfigShape|null */
    private BetaCompactionConfig|array|null $pendingCompaction = null;

    /** True while the caller is handling a yielded compaction response. */
    private bool $compacting = false;

    /** @var array<string, BetaRunnableTool> Runnable tools the history had removed when the compaction request was sent */
    private array $removedByHistory = [];

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
        self::rejectCompactionParam($extraParams);
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
     * Passing a different `tools` list also resets which tools the runner will
     * run to that list, dropping changes made with addTools() / removeTools(),
     * sent or not.
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

        self::rejectCompactionParam($new);
        if ($this->compacting && is_array($new['messages'] ?? null) && $new['messages'] !== $this->messages) {
            throw new \LogicException(self::MESSAGES_LOCKED);
        }
        if (null !== $this->pendingCompaction || $this->compacting) {
            self::assertNoCompactionEdit($new['contextManagement'] ?? null);
        }

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

        // A mutator hands back `tools` untouched; rebuilding the dispatch map then would undo addTools() / removeTools().
        if (is_array($new['tools'] ?? null) && $new['tools'] !== $this->tools) {
            /** @var list<BetaRunnableTool|BetaToolUnionShape> $tools */
            $tools = $new['tools'];
            $this->tools = $tools;
            $this->runnableToolsByName = [];
            $this->toolDefinitions = [];
            $this->pendingToolChanges = [];
            $this->removedByHistory = [];
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
        if ($this->compacting) {
            throw new \LogicException(self::MESSAGES_LOCKED);
        }

        /** @var list<array<string, mixed>> $normalized */
        $normalized = array_map(
            fn ($msg) => $msg instanceof BaseModel ? $msg->jsonSerialize() : $msg,
            $messages,
        );
        array_push($this->messages, ...$normalized);
        $this->mutated = true;
    }

    /**
     * Give the model more tools without changing `tools`, which would miss the prompt cache.
     *
     * A runnable tool can be called from the request that carries its definition. A plain definition
     * (a server tool, say) is sent as given and never run, and drops a runnable tool of the same name.
     * Pass the `inline-tools-2026-09-15` beta in `betas`; the runner does not add it.
     *
     * In the rare case where a compaction response comes back without `tool_changes` even though the
     * summarized messages added or removed tools, the model goes back to the tools in `tools` and the
     * runner does not detect it. Call addTools() / removeTools() again after that compaction if you
     * need the change restored.
     *
     * @param BetaRunnableTool|BetaToolUnionShape ...$tools
     */
    public function addTools(BetaRunnableTool|BaseModel|array ...$tools): void
    {
        foreach ($tools as $tool) {
            $this->pendingToolChanges[] = ['add' => $tool];
        }
    }

    /**
     * Take tools away from the model without changing `tools`, which would miss the prompt cache.
     *
     * The tools stop being run at once, even for a call in the message being handled; addTools() brings
     * one back. Pass the `inline-tools-2026-09-15` beta in `betas`; the runner does not add it.
     *
     * @param BetaRunnableTool|string ...$tools The tools to remove, or their names
     */
    public function removeTools(BetaRunnableTool|string ...$tools): void
    {
        foreach ($tools as $tool) {
            $name = $tool instanceof BetaRunnableTool ? $tool->name() : $tool;
            unset($this->runnableToolsByName[$name]);
            $this->pendingToolChanges[] = ['remove' => $name];
        }
    }

    /**
     * Compact the conversation before the model's next turn. Requires the `compact-2026-09-04` beta.
     *
     * This only schedules the compaction. Once the current turn has finished,
     * including any tool calls, the runner requests a summary and replaces the
     * message history with the response. On the last turn it compacts and then
     * stops, unless that turn was cut off with tool calls that were never run.
     *
     * The compaction response is yielded with a `compaction` stop reason and does
     * not count towards `maxIterations`. Calling this while handling it does
     * nothing, so a token threshold does not compact twice.
     *
     * @param BetaCompactionConfig|BetaCompactionConfigShape|null $compaction The same config create() takes as `compaction`. Defaults to `['type' => 'summarize']`.
     */
    public function compactBeforeNextTurn(BetaCompactionConfig|array|null $compaction = null): void
    {
        if ($this->compacting) {
            return;
        }

        self::assertNoCompactionEdit($this->extraParams['contextManagement'] ?? null);
        $this->pendingCompaction = $compaction ?? ['type' => 'summarize'];
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
        $turnPaused = false;
        $finalMessage = null;

        while (true) {
            if (null !== $this->maxIterations && $iterationCount >= $this->maxIterations) {
                break;
            }

            // Before the compaction check, so that a compaction due now summarizes the tool changes too.
            $this->sendPendingToolChanges($turnPaused);

            // The API cannot compact a conversation that ends mid-turn, so a paused turn is resumed first.
            if (null !== $this->pendingCompaction && !$turnPaused) {
                $compacted = $this->requestCompaction($this->pendingCompaction);
                $this->compacting = true;

                try {
                    yield $compacted;
                } finally {
                    $this->compacting = false;
                }

                $this->registerCompactionResponse($compacted);

                continue;
            }

            $this->mutated = false;
            ++$iterationCount;

            // @phpstan-ignore argument.type
            $message = $this->client->beta->messages->create(...$this->requestParams());

            yield $message;

            $nextStep = self::determineNextStepFromStopReason($message->stopReason);
            $turnPaused = self::STEP_RESUME === $nextStep;

            // If the caller mutated params during this yield, skip auto-appending
            // the assistant message — they are managing history manually this turn.
            // @phpstan-ignore booleanNot.alwaysTrue
            if (!$this->mutated) {
                $this->messages[] = ['role' => 'assistant', 'content' => $message->content];

                // Container-bound server tools reject a follow-up request that omits the container the
                // previous turn ran in, so carry its id forward unless the caller pinned one themselves.
                $containerID = ($message->container ?? null)?->id;
                if (null !== $containerID) {
                    $container = $this->extraParams['container'] ?? null;
                    if (null === $container) {
                        $this->extraParams['container'] = $containerID;
                    } elseif ($container instanceof BetaContainerParams && null === $container->id) {
                        $this->extraParams['container'] = $container->withID($containerID);
                    } elseif (is_array($container) && !isset($container['id'])) {
                        $this->extraParams['container'] = ['id' => $containerID] + $container;
                    }
                }

                if (self::STEP_STOP === $nextStep) {
                    $finalMessage = $message;

                    break;
                }

                if (self::STEP_RESUME === $nextStep) {
                    continue;
                }
            }

            $toolResults = $this->buildToolResults($this->messages[array_key_last($this->messages)]);

            if (null !== $toolResults) {
                $this->messages[] = ['role' => 'user', 'content' => $toolResults];
            } elseif (!$this->mutated) {
                $finalMessage = $message;

                break;
            }
        }

        $compaction = null === $finalMessage ? null : $this->pendingCompactionAfter($finalMessage);
        if (null !== $compaction) {
            $compacted = $this->requestCompaction($compaction);
            $this->compacting = true;

            try {
                yield $compacted;
            } finally {
                $this->compacting = false;
            }

            $this->registerCompactionResponse($compacted);
        }
    }

    /**
     * @return array<string, mixed> Named arguments for messages->create()
     */
    private function requestParams(): array
    {
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

        $params['requestOptions'] = [
            'extraHeaders' => [
                StainlessHelperHeader::HEADER => StainlessHelperHeader::BETA_TOOL_RUNNER,
            ],
        ];

        return $params;
    }

    /**
     * @param array<array-key, mixed> $params
     */
    private static function rejectCompactionParam(array $params): void
    {
        if (null !== ($params['compaction'] ?? null)) {
            throw new \InvalidArgumentException(
                '`compaction` cannot be set on a tool runner: every request in the loop would compact again. '
                .'Call compactBeforeNextTurn() when the conversation should be compacted instead.'
            );
        }
    }

    private static function assertNoCompactionEdit(mixed $contextManagement): void
    {
        // The compaction request is sent without `contextManagement`, so the API cannot reject this
        // combination there: it would run and bill the compaction, then reject the next request, where
        // the compaction response and the compaction edit meet.
        $contextManagement = self::toArray($contextManagement);
        if (!is_array($contextManagement)) {
            return;
        }

        $edits = $contextManagement['edits'] ?? null;
        if (!is_array($edits)) {
            return;
        }

        foreach ($edits as $edit) {
            $edit = self::toArray($edit);
            if (is_array($edit) && is_string($edit['type'] ?? null) && str_starts_with($edit['type'], 'compact_')) {
                throw new \LogicException(
                    'compactBeforeNextTurn() cannot be used while `contextManagement` has a compaction edit, '
                    .'because the API does not accept a compaction block together with one. Remove the edit first.'
                );
            }
        }
    }

    /**
     * @param BetaCompactionConfig|BetaCompactionConfigShape $compaction
     */
    private function requestCompaction(BetaCompactionConfig|array $compaction): BetaMessage
    {
        // Checked again here because `contextManagement` can be a model the caller still holds and edits in place.
        self::assertNoCompactionEdit($this->extraParams['contextManagement'] ?? null);
        $this->pendingCompaction = null;
        $this->removedByHistory = array_diff_key($this->runnableToolsByName, $this->availableToolNames());

        $params = self::withoutCompactionIncompatibleParams($this->requestParams());
        $params['compaction'] = $compaction;

        // @phpstan-ignore argument.type
        return $this->client->beta->messages->create(...$params);
    }

    /**
     * A compaction request returns only the compaction block, never a reply, so the API rejects the params that
     * only shape a reply. The runner's later requests keep them.
     *
     * @param array<string, mixed> $params Named arguments for messages->create()
     *
     * @return array<string, mixed> A copy of `$params` without them
     */
    private static function withoutCompactionIncompatibleParams(array $params): array
    {
        unset($params['contextManagement'], $params['stopSequences'], $params['outputFormat']);

        $toolChoice = self::toArray($params['toolChoice'] ?? null);
        if (is_array($toolChoice) && in_array($toolChoice['type'] ?? null, ['any', 'tool'], true)) {
            unset($params['toolChoice']);
        }

        if (isset($params['outputConfig'])) {
            $params['outputConfig'] = self::without($params['outputConfig'], 'format');
        }

        if (is_array($params['fallbacks'] ?? null)) {
            $params['fallbacks'] = array_map(
                static fn (mixed $fallback): mixed => self::without($fallback, 'outputConfig', 'format'),
                $params['fallbacks'],
            );
        }

        return $params;
    }

    /**
     * @return mixed `$value` without the key the path ends on; a model on the way is copied, never changed
     */
    private static function without(mixed $value, string $key, string ...$path): mixed
    {
        if ($value instanceof BaseModel) {
            $value = clone $value;
        } elseif (!is_array($value)) {
            return $value;
        }

        if ([] === $path) {
            unset($value[$key]);
        } elseif (isset($value[$key])) {
            $value[$key] = self::without($value[$key], ...$path);
        }

        return $value;
    }

    private function registerCompactionResponse(BetaMessage $message): void
    {
        foreach ($message->content as $block) {
            // By type, not class: a block type this SDK version does not model is parsed into another block's class.
            if ('compaction' !== ($block['type'] ?? null)) {
                continue;
            }

            $summary = $block['content'] ?? null;
            if (null === $summary || '' === $summary) {
                continue;
            }

            // The history's tool_removal blocks go with it, so what they took away leaves the dispatch map first.
            // Worked out before the yield, so a `tools` list the caller sets while handling the response stays whole.
            $this->runnableToolsByName = array_diff_key($this->runnableToolsByName, $this->removedByHistory);

            // The response has to be sent back as it came, first, replacing the messages it summarizes.
            $this->messages = [['role' => 'assistant', 'content' => $message->content]];

            return;
        }

        trigger_error('Compaction produced no summary; keeping the conversation as it is.', E_USER_WARNING);
    }

    /**
     * @return BetaCompactionConfig|BetaCompactionConfigShape|null The compaction to send now that the run has ended on this message
     */
    private function pendingCompactionAfter(BetaMessage $finalMessage): BetaCompactionConfig|array|null
    {
        if (null === $this->pendingCompaction) {
            return null;
        }

        foreach ($finalMessage->content as $block) {
            if ('tool_use' !== ($block['type'] ?? null)) {
                continue;
            }

            // A turn that was cut short can end with tool calls that are never run, and the API
            // cannot compact a conversation whose last turn has an unanswered tool call.
            $this->pendingCompaction = null;
            trigger_error(
                "The pending compaction was skipped because the last turn (stop reason: {$finalMessage->stopReason}) "
                .'ended with tool calls that were not run. '
                .'Call compactBeforeNextTurn() again if you continue the conversation.',
                E_USER_WARNING,
            );

            return null;
        }

        return $this->pendingCompaction;
    }

    private function sendPendingToolChanges(bool $turnPaused): void
    {
        // A paused turn goes back unchanged to be continued, so the changes wait for the request after it.
        if ([] === $this->pendingToolChanges || $turnPaused) {
            return;
        }

        $blocks = [];
        foreach ($this->pendingToolChanges as $change) {
            if (isset($change['remove'])) {
                unset($this->runnableToolsByName[$change['remove']]);
                $blocks[] = ['type' => 'tool_removal', 'tool' => ['type' => 'tool_reference', 'name' => $change['remove']]];

                continue;
            }

            $tool = $change['add'];
            $definition = $tool instanceof BetaRunnableTool ? $tool->definition : $tool;
            if ($tool instanceof BetaRunnableTool) {
                $this->runnableToolsByName[$tool->name()] = $tool;
            } elseif (is_string($definition['name'] ?? null)) {
                unset($this->runnableToolsByName[$definition['name']]);
            }

            $blocks[] = [
                'type' => 'tool_addition',
                'tool' => ['type' => 'tool_definition', 'definition' => self::toArray($definition)],
            ];
        }

        // Not pushMessages(): that marks the history as caller-edited, so the runner would not append this turn.
        $this->messages[] = ['role' => 'system', 'content' => $blocks];
        $this->pendingToolChanges = [];
    }

    /**
     * Decides how the loop treats a finished request from its stop reason.
     *
     * @return self::STEP_* one of three outcomes; unknown values from a newer API stop the loop
     */
    private static function determineNextStepFromStopReason(?string $stopReason): string
    {
        $reason = null === $stopReason ? null : BetaStopReason::tryFrom($stopReason);
        if (null === $reason) {
            return self::STEP_STOP;
        }

        // No default arm: PHPStan rejects a non-exhaustive match, so every new case must be classified here.
        return match ($reason) {
            BetaStopReason::TOOL_USE => self::STEP_RUN_TOOLS,
            // pause_after_compaction hands the turn back before the model answers; sending it back unchanged continues it.
            BetaStopReason::COMPACTION,
            BetaStopReason::PAUSE_TURN => self::STEP_RESUME,
            BetaStopReason::END_TURN,
            BetaStopReason::STOP_SEQUENCE,
            BetaStopReason::MAX_TOKENS,
            BetaStopReason::MODEL_CONTEXT_WINDOW_EXCEEDED,
            BetaStopReason::REFUSAL => self::STEP_STOP,
        };
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

        $available = $this->availableToolNames();

        return array_map(
            fn ($toolUse) => $this->executeToolUse(
                $toolUse,
                isset($available[$toolUse->name]) ? ($this->runnableToolsByName[$toolUse->name] ?? null) : null,
            ),
            $toolUseBlocks,
        );
    }

    /**
     * Names of the tools the model may currently call, as a set.
     *
     * Folds tool_removal / tool_addition blocks over the runner's runnable
     * tool names. They arrive in role "system" messages, and in the
     * tool_changes of a compaction block, which stands in for the system
     * messages of the turns it summarized. Removal is only a hint to the
     * model, which can still emit a tool_use for a removed tool — such a call
     * must behave exactly like a call to a tool that was never defined.
     *
     * @return array<string, true>
     */
    private function availableToolNames(): array
    {
        $available = array_fill_keys(array_keys($this->runnableToolsByName), true);

        foreach ($this->messages as $message) {
            $message = self::toArray($message);
            if (!is_array($message)) {
                continue;
            }

            $content = $message['content'] ?? null;
            if (!is_array($content)) {
                continue;
            }

            $role = $message['role'] ?? null;
            foreach ($content as $block) {
                $block = self::toArray($block);
                if ('system' === $role) {
                    $this->applyToolChange($block, $available);
                } elseif ('assistant' === $role && is_array($block) && 'compaction' === ($block['type'] ?? null)) {
                    // A hand-written array block may spell the key the way the SDK's array shapes do.
                    foreach ((array) ($block['tool_changes'] ?? $block['toolChanges'] ?? []) as $change) {
                        self::applyToolReferenceChange(self::toArray($change), $available);
                    }
                }
            }
        }

        return $available;
    }

    /**
     * @param array<string, true> $available
     */
    private function applyToolChange(mixed $block, array &$available): void
    {
        if (!is_array($block)) {
            return;
        }

        switch ($block['type'] ?? null) {
            case 'tool_removal':
            case 'tool_addition':
                self::applyToolReferenceChange($block, $available);

                break;

            case 'mid_conv_system':
                // The API schema limits mid_conv_system content to text /
                // tool_addition / tool_removal, so exactly one level is walked:
                // only its tool_addition / tool_removal inner blocks fold in,
                // and any other inner type is a no-op — no recursion.
                foreach ((array) ($block['content'] ?? []) as $inner) {
                    self::applyToolReferenceChange(self::toArray($inner), $available);
                }

                break;

            default:
                // Other and unknown/newer block types leave the set untouched
                // (forward compatibility) — never raise.
                break;
        }
    }

    /**
     * Folds one tool_removal / tool_addition block over the available set;
     * any other block type leaves the set untouched.
     *
     * @param array<string, true> $available
     */
    private static function applyToolReferenceChange(mixed $block, array &$available): void
    {
        if (!is_array($block)) {
            return;
        }

        switch ($block['type'] ?? null) {
            case 'tool_removal':
                if (null !== ($name = self::changedToolName($block['tool'] ?? null))) {
                    unset($available[$name]);
                }

                break;

            case 'tool_addition':
                if (null !== ($name = self::changedToolName($block['tool'] ?? null))) {
                    $available[$name] = true;
                }

                break;

            default:
                break;
        }
    }

    /**
     * tool_reference names a locally runnable tool directly and tool_definition
     * carries one by value; MCP references are executed server-side and
     * unknown/newer types are ignored.
     */
    private static function changedToolName(mixed $tool): ?string
    {
        $tool = self::toArray($tool);
        if (!is_array($tool)) {
            return null;
        }

        switch ($tool['type'] ?? null) {
            case 'tool_reference':
                return is_string($tool['name'] ?? null) ? $tool['name'] : null;

            case 'tool_definition':
                // Not every tools[] entry has a name (e.g. mcp_toolset); those are never locally runnable.
                $definition = self::toArray($tool['definition'] ?? null);

                return is_array($definition) && is_string($definition['name'] ?? null) ? $definition['name'] : null;

            default:
                return null;
        }
    }

    /**
     * History may hold typed SDK params/models as well as plain arrays; normalize to the API shape.
     */
    private static function toArray(mixed $value): mixed
    {
        return $value instanceof \JsonSerializable ? $value->jsonSerialize() : $value;
    }

    /**
     * @param BetaRunnableTool|null $tool The currently-available tool matching the call, if any
     *
     * @return array<string, mixed>
     */
    private function executeToolUse(BetaToolUseBlock $toolUse, ?BetaRunnableTool $tool): array
    {
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
