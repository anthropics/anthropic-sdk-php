<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Messages;

use Anthropic\Models\CacheControlEphemeral;
use Anthropic\Models\MessageParam;
use Anthropic\Models\Messages\DeletedMessageBatch;
use Anthropic\Models\Messages\MessageBatch;
use Anthropic\Models\Messages\MessageBatchIndividualResponse;
use Anthropic\Models\Metadata;
use Anthropic\Models\TextBlockParam;
use Anthropic\Models\ThinkingConfigDisabled;
use Anthropic\Models\ThinkingConfigEnabled;
use Anthropic\Models\Tool;
use Anthropic\Models\ToolBash20250124;
use Anthropic\Models\ToolChoiceAny;
use Anthropic\Models\ToolChoiceAuto;
use Anthropic\Models\ToolChoiceNone;
use Anthropic\Models\ToolChoiceTool;
use Anthropic\Models\ToolTextEditor20250124;
use Anthropic\Models\WebSearchTool20250305;
use Anthropic\RequestOptions;

interface BatchesContract
{
    /**
     * @param array{
     *   requests?: list<array{
     *     customID?: string,
     *     params?: array{
     *       maxTokens?: int,
     *       messages?: list<MessageParam>,
     *       model?: string|string,
     *       metadata?: Metadata,
     *       serviceTier?: string,
     *       stopSequences?: list<string>,
     *       stream?: bool,
     *       system?: string|list<TextBlockParam>,
     *       temperature?: float,
     *       thinking?: ThinkingConfigEnabled|ThinkingConfigDisabled,
     *       toolChoice?: ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone,
     *       tools?: list<Tool|ToolBash20250124|ToolTextEditor20250124|array{
     *         name?: string, type?: string, cacheControl?: CacheControlEphemeral
     *       }|WebSearchTool20250305>,
     *       topK?: int,
     *       topP?: float,
     *     },
     *   }>,
     * } $params
     */
    public function create(
        array $params,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @param array{messageBatchID?: string} $params
     */
    public function retrieve(
        string $messageBatchID,
        array $params,
        ?RequestOptions $requestOptions = null,
    ): MessageBatch;

    /**
     * @param array{afterID?: string, beforeID?: string, limit?: int} $params
     */
    public function list(
        array $params,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @param array{messageBatchID?: string} $params
     */
    public function delete(
        string $messageBatchID,
        array $params,
        ?RequestOptions $requestOptions = null,
    ): DeletedMessageBatch;

    /**
     * @param array{messageBatchID?: string} $params
     */
    public function cancel(
        string $messageBatchID,
        array $params,
        ?RequestOptions $requestOptions = null,
    ): MessageBatch;

    /**
     * @param array{messageBatchID?: string} $params
     */
    public function results(
        string $messageBatchID,
        array $params,
        ?RequestOptions $requestOptions = null,
    ): MessageBatchIndividualResponse;
}
