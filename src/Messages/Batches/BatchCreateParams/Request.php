<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches\BatchCreateParams;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Batches\BatchCreateParams\Request\Params;
use Anthropic\Messages\Batches\BatchCreateParams\Request\Params\ServiceTier;
use Anthropic\Messages\MessageParam;
use Anthropic\Messages\Metadata;
use Anthropic\Messages\Model;
use Anthropic\Messages\TextBlockParam;
use Anthropic\Messages\ThinkingConfigDisabled;
use Anthropic\Messages\ThinkingConfigEnabled;
use Anthropic\Messages\Tool;
use Anthropic\Messages\ToolBash20250124;
use Anthropic\Messages\ToolChoiceAny;
use Anthropic\Messages\ToolChoiceAuto;
use Anthropic\Messages\ToolChoiceNone;
use Anthropic\Messages\ToolChoiceTool;
use Anthropic\Messages\ToolTextEditor20250124;
use Anthropic\Messages\ToolTextEditor20250429;
use Anthropic\Messages\ToolTextEditor20250728;
use Anthropic\Messages\WebSearchTool20250305;

/**
 * @phpstan-type RequestShape = array{customID: string, params: Params}
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
    #[Required('custom_id')]
    public string $customID;

    /**
     * Messages API creation parameters for the individual request.
     *
     * See the [Messages API reference](https://docs.claude.com/en/api/messages) for full documentation on available parameters.
     */
    #[Required]
    public Params $params;

    /**
     * `new Request()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Request::with(customID: ..., params: ...)
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
     *   maxTokens: int,
     *   messages: list<MessageParam>,
     *   model: string|value-of<Model>,
     *   metadata?: Metadata|null,
     *   serviceTier?: value-of<ServiceTier>|null,
     *   stopSequences?: list<string>|null,
     *   stream?: bool|null,
     *   system?: string|list<TextBlockParam>|null,
     *   temperature?: float|null,
     *   thinking?: ThinkingConfigEnabled|ThinkingConfigDisabled|null,
     *   toolChoice?: ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone|null,
     *   tools?: list<Tool|ToolBash20250124|ToolTextEditor20250124|ToolTextEditor20250429|ToolTextEditor20250728|WebSearchTool20250305>|null,
     *   topK?: int|null,
     *   topP?: float|null,
     * } $params
     */
    public static function with(string $customID, Params|array $params): self
    {
        $obj = new self;

        $obj['customID'] = $customID;
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
        $obj['customID'] = $customID;

        return $obj;
    }

    /**
     * Messages API creation parameters for the individual request.
     *
     * See the [Messages API reference](https://docs.claude.com/en/api/messages) for full documentation on available parameters.
     *
     * @param Params|array{
     *   maxTokens: int,
     *   messages: list<MessageParam>,
     *   model: string|value-of<Model>,
     *   metadata?: Metadata|null,
     *   serviceTier?: value-of<ServiceTier>|null,
     *   stopSequences?: list<string>|null,
     *   stream?: bool|null,
     *   system?: string|list<TextBlockParam>|null,
     *   temperature?: float|null,
     *   thinking?: ThinkingConfigEnabled|ThinkingConfigDisabled|null,
     *   toolChoice?: ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone|null,
     *   tools?: list<Tool|ToolBash20250124|ToolTextEditor20250124|ToolTextEditor20250429|ToolTextEditor20250728|WebSearchTool20250305>|null,
     *   topK?: int|null,
     *   topP?: float|null,
     * } $params
     */
    public function withParams(Params|array $params): self
    {
        $obj = clone $this;
        $obj['params'] = $params;

        return $obj;
    }
}
