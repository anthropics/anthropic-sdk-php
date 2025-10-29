<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaTextEditorCodeExecutionToolResultBlockParamShape = array{
 *   content: BetaTextEditorCodeExecutionToolResultErrorParam|BetaTextEditorCodeExecutionViewResultBlockParam|BetaTextEditorCodeExecutionCreateResultBlockParam|BetaTextEditorCodeExecutionStrReplaceResultBlockParam,
 *   toolUseID: string,
 *   type: string,
 *   cacheControl?: BetaCacheControlEphemeral|null,
 * }
 */
final class BetaTextEditorCodeExecutionToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaTextEditorCodeExecutionToolResultBlockParamShape> */
    use SdkModel;

    #[Api]
    public string $type = 'text_editor_code_execution_tool_result';

    #[Api]
    public BetaTextEditorCodeExecutionToolResultErrorParam|BetaTextEditorCodeExecutionViewResultBlockParam|BetaTextEditorCodeExecutionCreateResultBlockParam|BetaTextEditorCodeExecutionStrReplaceResultBlockParam $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * `new BetaTextEditorCodeExecutionToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTextEditorCodeExecutionToolResultBlockParam::with(
     *   content: ..., toolUseID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaTextEditorCodeExecutionToolResultBlockParam)
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
        BetaTextEditorCodeExecutionToolResultErrorParam|BetaTextEditorCodeExecutionViewResultBlockParam|BetaTextEditorCodeExecutionCreateResultBlockParam|BetaTextEditorCodeExecutionStrReplaceResultBlockParam $content,
        string $toolUseID,
        ?BetaCacheControlEphemeral $cacheControl = null,
    ): self {
        $obj = new self;

        $obj->content = $content;
        $obj->toolUseID = $toolUseID;

        null !== $cacheControl && $obj->cacheControl = $cacheControl;

        return $obj;
    }

    public function withContent(
        BetaTextEditorCodeExecutionToolResultErrorParam|BetaTextEditorCodeExecutionViewResultBlockParam|BetaTextEditorCodeExecutionCreateResultBlockParam|BetaTextEditorCodeExecutionStrReplaceResultBlockParam $content,
    ): self {
        $obj = clone $this;
        $obj->content = $content;

        return $obj;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $obj = clone $this;
        $obj->toolUseID = $toolUseID;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function withCacheControl(
        ?BetaCacheControlEphemeral $cacheControl
    ): self {
        $obj = clone $this;
        $obj->cacheControl = $cacheControl;

        return $obj;
    }
}
