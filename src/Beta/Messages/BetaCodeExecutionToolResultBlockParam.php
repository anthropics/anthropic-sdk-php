<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCodeExecutionToolResultBlockParamShape = array{
 *   content: BetaCodeExecutionToolResultErrorParam|BetaCodeExecutionResultBlockParam,
 *   tool_use_id: string,
 *   type: "code_execution_tool_result",
 *   cache_control?: BetaCacheControlEphemeral|null,
 * }
 */
final class BetaCodeExecutionToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaCodeExecutionToolResultBlockParamShape> */
    use SdkModel;

    /** @var "code_execution_tool_result" $type */
    #[Api]
    public string $type = 'code_execution_tool_result';

    #[Api]
    public BetaCodeExecutionToolResultErrorParam|BetaCodeExecutionResultBlockParam $content;

    #[Api]
    public string $tool_use_id;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cache_control;

    /**
     * `new BetaCodeExecutionToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCodeExecutionToolResultBlockParam::with(content: ..., tool_use_id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCodeExecutionToolResultBlockParam)
     *   ->withContent(...)
     *   ->withToolUseID(...)
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
     */
    public static function with(
        BetaCodeExecutionToolResultErrorParam|BetaCodeExecutionResultBlockParam $content,
        string $tool_use_id,
        ?BetaCacheControlEphemeral $cache_control = null,
    ): self {
        $obj = new self;

        $obj->content = $content;
        $obj->tool_use_id = $tool_use_id;

        null !== $cache_control && $obj->cache_control = $cache_control;

        return $obj;
    }

    public function withContent(
        BetaCodeExecutionToolResultErrorParam|BetaCodeExecutionResultBlockParam $content,
    ): self {
        $obj = clone $this;
        $obj->content = $content;

        return $obj;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $obj = clone $this;
        $obj->tool_use_id = $toolUseID;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function withCacheControl(
        ?BetaCacheControlEphemeral $cacheControl
    ): self {
        $obj = clone $this;
        $obj->cache_control = $cacheControl;

        return $obj;
    }
}
