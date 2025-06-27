<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Messages;

use Anthropic\RequestOptions;
use Anthropic\Models\MessageParam;
use Anthropic\Models\Metadata;
use Anthropic\Models\TextBlockParam;
use Anthropic\Models\ThinkingConfigEnabled;
use Anthropic\Models\ThinkingConfigDisabled;
use Anthropic\Models\ToolChoiceAuto;
use Anthropic\Models\ToolChoiceAny;
use Anthropic\Models\ToolChoiceTool;
use Anthropic\Models\ToolChoiceNone;
use Anthropic\Models\Tool;
use Anthropic\Models\ToolBash20250124;
use Anthropic\Models\ToolTextEditor20250124;
use Anthropic\Models\CacheControlEphemeral;
use Anthropic\Models\WebSearchTool20250305;
use Anthropic\Models\Messages\MessageBatch;
use Anthropic\Models\Messages\DeletedMessageBatch;
use Anthropic\Models\Messages\MessageBatchIndividualResponse;

interface BatchesContract
{
    /**
     * @param array{
     *
     *       requests?: list<array{
     *
     *           customID?: string,
     *           params?: array{
     *
     *               maxTokens?: int,
     *               messages?: list<MessageParam>,
     *               model?: string|string,
     *               metadata?: Metadata,
     *               serviceTier?: string,
     *               stopSequences?: list<string>,
     *               stream?: bool,
     *               system?: string|list<TextBlockParam>,
     *               temperature?: float,
     *               thinking?: ThinkingConfigEnabled|ThinkingConfigDisabled,
     *               toolChoice?: ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone,
     *               tools?: list<Tool|ToolBash20250124|ToolTextEditor20250124|array{
     *
     *                   name?: string,
     *                   type?: string,
     *                   cacheControl?: CacheControlEphemeral,
     *
     * }|WebSearchTool20250305>,
     *               topK?: int,
     *               topP?: float,
     *
     * },
     *
     * }>,
     *
     * } $params
     * @param RequestOptions|array{
     *
     *       timeout?: float|null,
     *       maxRetries?: int|null,
     *       initialRetryDelay?: float|null,
     *       maxRetryDelay?: float|null,
     *       extraHeaders?: list<string>|null,
     *       extraQueryParams?: list<string>|null,
     *       extraBodyParams?: list<string>|null,
     *
     * }|null $requestOptions
     */
    public function create(
        array $params,
        mixed $requestOptions = [],
    ): MessageBatch;

    /**
     * @param array{messageBatchID?: string} $params
     * @param RequestOptions|array{
     *
     *       timeout?: float|null,
     *       maxRetries?: int|null,
     *       initialRetryDelay?: float|null,
     *       maxRetryDelay?: float|null,
     *       extraHeaders?: list<string>|null,
     *       extraQueryParams?: list<string>|null,
     *       extraBodyParams?: list<string>|null,
     *
     * }|null $requestOptions
     */
    public function retrieve(
        string $messageBatchID,
        array $params,
        mixed $requestOptions = [],
    ): MessageBatch;

    /**
     * @param array{afterID?: string, beforeID?: string, limit?: int} $params
     * @param RequestOptions|array{
     *
     *       timeout?: float|null,
     *       maxRetries?: int|null,
     *       initialRetryDelay?: float|null,
     *       maxRetryDelay?: float|null,
     *       extraHeaders?: list<string>|null,
     *       extraQueryParams?: list<string>|null,
     *       extraBodyParams?: list<string>|null,
     *
     * }|null $requestOptions
     */
    public function list(
        array $params,
        mixed $requestOptions = [],
    ): MessageBatch;

    /**
     * @param array{messageBatchID?: string} $params
     * @param RequestOptions|array{
     *
     *       timeout?: float|null,
     *       maxRetries?: int|null,
     *       initialRetryDelay?: float|null,
     *       maxRetryDelay?: float|null,
     *       extraHeaders?: list<string>|null,
     *       extraQueryParams?: list<string>|null,
     *       extraBodyParams?: list<string>|null,
     *
     * }|null $requestOptions
     */
    public function delete(
        string $messageBatchID,
        array $params,
        mixed $requestOptions = [],
    ): DeletedMessageBatch;

    /**
     * @param array{messageBatchID?: string} $params
     * @param RequestOptions|array{
     *
     *       timeout?: float|null,
     *       maxRetries?: int|null,
     *       initialRetryDelay?: float|null,
     *       maxRetryDelay?: float|null,
     *       extraHeaders?: list<string>|null,
     *       extraQueryParams?: list<string>|null,
     *       extraBodyParams?: list<string>|null,
     *
     * }|null $requestOptions
     */
    public function cancel(
        string $messageBatchID,
        array $params,
        mixed $requestOptions = [],
    ): MessageBatch;

    /**
     * @param array{messageBatchID?: string} $params
     * @param RequestOptions|array{
     *
     *       timeout?: float|null,
     *       maxRetries?: int|null,
     *       initialRetryDelay?: float|null,
     *       maxRetryDelay?: float|null,
     *       extraHeaders?: list<string>|null,
     *       extraQueryParams?: list<string>|null,
     *       extraBodyParams?: list<string>|null,
     *
     * }|null $requestOptions
     */
    public function results(
        string $messageBatchID,
        array $params,
        mixed $requestOptions = [],
    ): MessageBatchIndividualResponse;
}
