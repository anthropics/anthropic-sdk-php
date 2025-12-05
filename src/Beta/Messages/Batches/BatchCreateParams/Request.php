<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches\BatchCreateParams;

use Anthropic\Beta\Messages\Batches\BatchCreateParams\Request\Params;
use Anthropic\Beta\Messages\Batches\BatchCreateParams\Request\Params\ServiceTier;
use Anthropic\Beta\Messages\BetaCodeExecutionTool20250522;
use Anthropic\Beta\Messages\BetaCodeExecutionTool20250825;
use Anthropic\Beta\Messages\BetaContainerParams;
use Anthropic\Beta\Messages\BetaContextManagementConfig;
use Anthropic\Beta\Messages\BetaJSONOutputFormat;
use Anthropic\Beta\Messages\BetaMCPToolset;
use Anthropic\Beta\Messages\BetaMemoryTool20250818;
use Anthropic\Beta\Messages\BetaMessageParam;
use Anthropic\Beta\Messages\BetaMetadata;
use Anthropic\Beta\Messages\BetaOutputConfig;
use Anthropic\Beta\Messages\BetaRequestMCPServerURLDefinition;
use Anthropic\Beta\Messages\BetaTextBlockParam;
use Anthropic\Beta\Messages\BetaThinkingConfigDisabled;
use Anthropic\Beta\Messages\BetaThinkingConfigEnabled;
use Anthropic\Beta\Messages\BetaTool;
use Anthropic\Beta\Messages\BetaToolBash20241022;
use Anthropic\Beta\Messages\BetaToolBash20250124;
use Anthropic\Beta\Messages\BetaToolChoiceAny;
use Anthropic\Beta\Messages\BetaToolChoiceAuto;
use Anthropic\Beta\Messages\BetaToolChoiceNone;
use Anthropic\Beta\Messages\BetaToolChoiceTool;
use Anthropic\Beta\Messages\BetaToolComputerUse20241022;
use Anthropic\Beta\Messages\BetaToolComputerUse20250124;
use Anthropic\Beta\Messages\BetaToolComputerUse20251124;
use Anthropic\Beta\Messages\BetaToolSearchToolBm25_20251119;
use Anthropic\Beta\Messages\BetaToolSearchToolRegex20251119;
use Anthropic\Beta\Messages\BetaToolTextEditor20241022;
use Anthropic\Beta\Messages\BetaToolTextEditor20250124;
use Anthropic\Beta\Messages\BetaToolTextEditor20250429;
use Anthropic\Beta\Messages\BetaToolTextEditor20250728;
use Anthropic\Beta\Messages\BetaWebFetchTool20250910;
use Anthropic\Beta\Messages\BetaWebSearchTool20250305;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Model;

/**
 * @phpstan-type RequestShape = array{custom_id: string, params: Params}
 */
final class Request implements BaseModel
{
    /** @use SdkModel<RequestShape> */
    use SdkModel;

    /**
     * Developer-provided ID created for each request in a Message Batch. Useful for matching results to requests, as results may be given out of request order.
     *
     * Must be unique for each request within the Message Batch.
     */
    #[Api]
    public string $custom_id;

    /**
     * Messages API creation parameters for the individual request.
     *
     * See the [Messages API reference](https://docs.claude.com/en/api/messages) for full documentation on available parameters.
     */
    #[Api]
    public Params $params;

    /**
     * `new Request()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Request::with(custom_id: ..., params: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Request)->withCustomID(...)->withParams(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Params|array{
     *   max_tokens: int,
     *   messages: list<BetaMessageParam>,
     *   model: string|value-of<Model>,
     *   container?: string|BetaContainerParams|null,
     *   context_management?: BetaContextManagementConfig|null,
     *   mcp_servers?: list<BetaRequestMCPServerURLDefinition>|null,
     *   metadata?: BetaMetadata|null,
     *   output_config?: BetaOutputConfig|null,
     *   output_format?: BetaJSONOutputFormat|null,
     *   service_tier?: value-of<ServiceTier>|null,
     *   stop_sequences?: list<string>|null,
     *   stream?: bool|null,
     *   system?: string|list<BetaTextBlockParam>|null,
     *   temperature?: float|null,
     *   thinking?: BetaThinkingConfigEnabled|BetaThinkingConfigDisabled|null,
     *   tool_choice?: BetaToolChoiceAuto|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone|null,
     *   tools?: list<BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaCodeExecutionTool20250522|BetaCodeExecutionTool20250825|BetaToolComputerUse20241022|BetaMemoryTool20250818|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolComputerUse20251124|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaToolTextEditor20250728|BetaWebSearchTool20250305|BetaWebFetchTool20250910|BetaToolSearchToolBm25_20251119|BetaToolSearchToolRegex20251119|BetaMCPToolset>|null,
     *   top_k?: int|null,
     *   top_p?: float|null,
     * } $params
     */
    public static function with(string $custom_id, Params|array $params): self
    {
        $obj = new self;

        $obj['custom_id'] = $custom_id;
        $obj['params'] = $params;

        return $obj;
    }

    /**
     * Developer-provided ID created for each request in a Message Batch. Useful for matching results to requests, as results may be given out of request order.
     *
     * Must be unique for each request within the Message Batch.
     */
    public function withCustomID(string $customID): self
    {
        $obj = clone $this;
        $obj['custom_id'] = $customID;

        return $obj;
    }

    /**
     * Messages API creation parameters for the individual request.
     *
     * See the [Messages API reference](https://docs.claude.com/en/api/messages) for full documentation on available parameters.
     *
     * @param Params|array{
     *   max_tokens: int,
     *   messages: list<BetaMessageParam>,
     *   model: string|value-of<Model>,
     *   container?: string|BetaContainerParams|null,
     *   context_management?: BetaContextManagementConfig|null,
     *   mcp_servers?: list<BetaRequestMCPServerURLDefinition>|null,
     *   metadata?: BetaMetadata|null,
     *   output_config?: BetaOutputConfig|null,
     *   output_format?: BetaJSONOutputFormat|null,
     *   service_tier?: value-of<ServiceTier>|null,
     *   stop_sequences?: list<string>|null,
     *   stream?: bool|null,
     *   system?: string|list<BetaTextBlockParam>|null,
     *   temperature?: float|null,
     *   thinking?: BetaThinkingConfigEnabled|BetaThinkingConfigDisabled|null,
     *   tool_choice?: BetaToolChoiceAuto|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone|null,
     *   tools?: list<BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaCodeExecutionTool20250522|BetaCodeExecutionTool20250825|BetaToolComputerUse20241022|BetaMemoryTool20250818|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolComputerUse20251124|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaToolTextEditor20250728|BetaWebSearchTool20250305|BetaWebFetchTool20250910|BetaToolSearchToolBm25_20251119|BetaToolSearchToolRegex20251119|BetaMCPToolset>|null,
     *   top_k?: int|null,
     *   top_p?: float|null,
     * } $params
     */
    public function withParams(Params|array $params): self
    {
        $obj = clone $this;
        $obj['params'] = $params;

        return $obj;
    }
}
