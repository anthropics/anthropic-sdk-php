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
 *   tool_use_id: string,
 *   type: 'text_editor_code_execution_tool_result',
 *   cache_control?: BetaCacheControlEphemeral|null,
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

    #[Required]
    public string $tool_use_id;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional(nullable: true)]
    public ?BetaCacheControlEphemeral $cache_control;

    /**
     * `new BetaTextEditorCodeExecutionToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTextEditorCodeExecutionToolResultBlockParam::with(
     *   content: ..., tool_use_id: ...
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
     *   error_code: value-of<ErrorCode>,
     *   type: 'text_editor_code_execution_tool_result_error',
     *   error_message?: string|null,
     * }|BetaTextEditorCodeExecutionViewResultBlockParam|array{
     *   content: string,
     *   file_type: value-of<FileType>,
     *   type: 'text_editor_code_execution_view_result',
     *   num_lines?: int|null,
     *   start_line?: int|null,
     *   total_lines?: int|null,
     * }|BetaTextEditorCodeExecutionCreateResultBlockParam|array{
     *   is_file_update: bool, type: 'text_editor_code_execution_create_result'
     * }|BetaTextEditorCodeExecutionStrReplaceResultBlockParam|array{
     *   type: 'text_editor_code_execution_str_replace_result',
     *   lines?: list<string>|null,
     *   new_lines?: int|null,
     *   new_start?: int|null,
     *   old_lines?: int|null,
     *   old_start?: int|null,
     * } $content
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cache_control
     */
    public static function with(
        BetaTextEditorCodeExecutionToolResultErrorParam|array|BetaTextEditorCodeExecutionViewResultBlockParam|BetaTextEditorCodeExecutionCreateResultBlockParam|BetaTextEditorCodeExecutionStrReplaceResultBlockParam $content,
        string $tool_use_id,
        BetaCacheControlEphemeral|array|null $cache_control = null,
    ): self {
        $obj = new self;

        $obj['content'] = $content;
        $obj['tool_use_id'] = $tool_use_id;

        null !== $cache_control && $obj['cache_control'] = $cache_control;

        return $obj;
    }

    /**
     * @param BetaTextEditorCodeExecutionToolResultErrorParam|array{
     *   error_code: value-of<ErrorCode>,
     *   type: 'text_editor_code_execution_tool_result_error',
     *   error_message?: string|null,
     * }|BetaTextEditorCodeExecutionViewResultBlockParam|array{
     *   content: string,
     *   file_type: value-of<FileType>,
     *   type: 'text_editor_code_execution_view_result',
     *   num_lines?: int|null,
     *   start_line?: int|null,
     *   total_lines?: int|null,
     * }|BetaTextEditorCodeExecutionCreateResultBlockParam|array{
     *   is_file_update: bool, type: 'text_editor_code_execution_create_result'
     * }|BetaTextEditorCodeExecutionStrReplaceResultBlockParam|array{
     *   type: 'text_editor_code_execution_str_replace_result',
     *   lines?: list<string>|null,
     *   new_lines?: int|null,
     *   new_start?: int|null,
     *   old_lines?: int|null,
     *   old_start?: int|null,
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
        $obj['tool_use_id'] = $toolUseID;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $obj = clone $this;
        $obj['cache_control'] = $cacheControl;

        return $obj;
    }
}
