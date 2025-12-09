<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultErrorParam\ErrorCode;
use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionViewResultBlockParam\FileType;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaTextEditorCodeExecutionToolResultBlockParamShape = array{
 *   content: BetaTextEditorCodeExecutionToolResultErrorParam|BetaTextEditorCodeExecutionViewResultBlockParam|BetaTextEditorCodeExecutionCreateResultBlockParam|BetaTextEditorCodeExecutionStrReplaceResultBlockParam,
 *   toolUseID: string,
 *   type?: 'text_editor_code_execution_tool_result',
 *   cacheControl?: BetaCacheControlEphemeral|null,
 * }
 */
final class BetaTextEditorCodeExecutionToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaTextEditorCodeExecutionToolResultBlockParamShape> */
    use SdkModel;

    /** @var 'text_editor_code_execution_tool_result' $type */
    #[Required]
    public string $type = 'text_editor_code_execution_tool_result';

    #[Required]
    public BetaTextEditorCodeExecutionToolResultErrorParam|BetaTextEditorCodeExecutionViewResultBlockParam|BetaTextEditorCodeExecutionCreateResultBlockParam|BetaTextEditorCodeExecutionStrReplaceResultBlockParam $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
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
     *
     * @param BetaTextEditorCodeExecutionToolResultErrorParam|array{
     *   errorCode: value-of<ErrorCode>,
     *   type?: 'text_editor_code_execution_tool_result_error',
     *   errorMessage?: string|null,
     * }|BetaTextEditorCodeExecutionViewResultBlockParam|array{
     *   content: string,
     *   fileType: value-of<FileType>,
     *   type?: 'text_editor_code_execution_view_result',
     *   numLines?: int|null,
     *   startLine?: int|null,
     *   totalLines?: int|null,
     * }|BetaTextEditorCodeExecutionCreateResultBlockParam|array{
     *   isFileUpdate: bool, type?: 'text_editor_code_execution_create_result'
     * }|BetaTextEditorCodeExecutionStrReplaceResultBlockParam|array{
     *   type?: 'text_editor_code_execution_str_replace_result',
     *   lines?: list<string>|null,
     *   newLines?: int|null,
     *   newStart?: int|null,
     *   oldLines?: int|null,
     *   oldStart?: int|null,
     * } $content
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public static function with(
        BetaTextEditorCodeExecutionToolResultErrorParam|array|BetaTextEditorCodeExecutionViewResultBlockParam|BetaTextEditorCodeExecutionCreateResultBlockParam|BetaTextEditorCodeExecutionStrReplaceResultBlockParam $content,
        string $toolUseID,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
    ): self {
        $obj = new self;

        $obj['content'] = $content;
        $obj['toolUseID'] = $toolUseID;

        null !== $cacheControl && $obj['cacheControl'] = $cacheControl;

        return $obj;
    }

    /**
     * @param BetaTextEditorCodeExecutionToolResultErrorParam|array{
     *   errorCode: value-of<ErrorCode>,
     *   type?: 'text_editor_code_execution_tool_result_error',
     *   errorMessage?: string|null,
     * }|BetaTextEditorCodeExecutionViewResultBlockParam|array{
     *   content: string,
     *   fileType: value-of<FileType>,
     *   type?: 'text_editor_code_execution_view_result',
     *   numLines?: int|null,
     *   startLine?: int|null,
     *   totalLines?: int|null,
     * }|BetaTextEditorCodeExecutionCreateResultBlockParam|array{
     *   isFileUpdate: bool, type?: 'text_editor_code_execution_create_result'
     * }|BetaTextEditorCodeExecutionStrReplaceResultBlockParam|array{
     *   type?: 'text_editor_code_execution_str_replace_result',
     *   lines?: list<string>|null,
     *   newLines?: int|null,
     *   newStart?: int|null,
     *   oldLines?: int|null,
     *   oldStart?: int|null,
     * } $content
     */
    public function withContent(
        BetaTextEditorCodeExecutionToolResultErrorParam|array|BetaTextEditorCodeExecutionViewResultBlockParam|BetaTextEditorCodeExecutionCreateResultBlockParam|BetaTextEditorCodeExecutionStrReplaceResultBlockParam $content,
    ): self {
        $obj = clone $this;
        $obj['content'] = $content;

        return $obj;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $obj = clone $this;
        $obj['toolUseID'] = $toolUseID;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $obj = clone $this;
        $obj['cacheControl'] = $cacheControl;

        return $obj;
    }
}
