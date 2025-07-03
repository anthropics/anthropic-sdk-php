<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Beta\Messages;

use Anthropic\Models\Beta\BetaCodeExecutionTool20250522;
use Anthropic\Models\Beta\BetaMessageParam;
use Anthropic\Models\Beta\BetaMetadata;
use Anthropic\Models\Beta\BetaRequestMCPServerURLDefinition;
use Anthropic\Models\Beta\BetaTextBlockParam;
use Anthropic\Models\Beta\BetaThinkingConfigDisabled;
use Anthropic\Models\Beta\BetaThinkingConfigEnabled;
use Anthropic\Models\Beta\BetaTool;
use Anthropic\Models\Beta\BetaToolBash20241022;
use Anthropic\Models\Beta\BetaToolBash20250124;
use Anthropic\Models\Beta\BetaToolChoiceAny;
use Anthropic\Models\Beta\BetaToolChoiceAuto;
use Anthropic\Models\Beta\BetaToolChoiceNone;
use Anthropic\Models\Beta\BetaToolChoiceTool;
use Anthropic\Models\Beta\BetaToolComputerUse20241022;
use Anthropic\Models\Beta\BetaToolComputerUse20250124;
use Anthropic\Models\Beta\BetaToolTextEditor20241022;
use Anthropic\Models\Beta\BetaToolTextEditor20250124;
use Anthropic\Models\Beta\BetaToolTextEditor20250429;
use Anthropic\Models\Beta\BetaWebSearchTool20250305;
use Anthropic\Models\Beta\Messages\BetaDeletedMessageBatch;
use Anthropic\Models\Beta\Messages\BetaMessageBatch;
use Anthropic\Models\Beta\Messages\BetaMessageBatchIndividualResponse;
use Anthropic\RequestOptions;

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
     *               messages?: list<BetaMessageParam>,
     *               model?: string|string,
     *               container?: string|null,
     *               mcpServers?: list<BetaRequestMCPServerURLDefinition>,
     *               metadata?: BetaMetadata,
     *               serviceTier?: string,
     *               stopSequences?: list<string>,
     *               stream?: bool,
     *               system?: string|list<BetaTextBlockParam>,
     *               temperature?: float,
     *               thinking?: BetaThinkingConfigEnabled|BetaThinkingConfigDisabled,
     *               toolChoice?: BetaToolChoiceAuto|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone,
     *               tools?: list<BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaCodeExecutionTool20250522|BetaToolComputerUse20241022|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaWebSearchTool20250305>,
     *               topK?: int,
     *               topP?: float,
     *
     * },
     *
     * }>,
     *       betas?: list<string|string>,
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
        mixed $requestOptions = []
    ): BetaMessageBatch;

    /**
     * @param array{
     *
     * messageBatchID?: string, betas?: list<string|string>
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
    public function retrieve(
        string $messageBatchID,
        array $params,
        mixed $requestOptions = []
    ): BetaMessageBatch;

    /**
     * @param array{
     *
     *       afterID?: string,
     *       beforeID?: string,
     *       limit?: int,
     *       betas?: list<string|string>,
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
    public function list(
        array $params,
        mixed $requestOptions = []
    ): BetaMessageBatch;

    /**
     * @param array{
     *
     * messageBatchID?: string, betas?: list<string|string>
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
    public function delete(
        string $messageBatchID,
        array $params,
        mixed $requestOptions = []
    ): BetaDeletedMessageBatch;

    /**
     * @param array{
     *
     * messageBatchID?: string, betas?: list<string|string>
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
    public function cancel(
        string $messageBatchID,
        array $params,
        mixed $requestOptions = []
    ): BetaMessageBatch;

    /**
     * @param array{
     *
     * messageBatchID?: string, betas?: list<string|string>
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
    public function results(
        string $messageBatchID,
        array $params,
        mixed $requestOptions = []
    ): BetaMessageBatchIndividualResponse;
}
