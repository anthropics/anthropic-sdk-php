<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultError\ErrorCode;
use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionViewResultBlock\FileType;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaTextEditorCodeExecutionToolResultBlockShape = array{
 *   content: BetaTextEditorCodeExecutionToolResultError|BetaTextEditorCodeExecutionViewResultBlock|BetaTextEditorCodeExecutionCreateResultBlock|BetaTextEditorCodeExecutionStrReplaceResultBlock,
 *   tool_use_id: string,
 *   type: 'text_editor_code_execution_tool_result',
 * }
 */
final class BetaTextEditorCodeExecutionToolResultBlock implements BaseModel
{
    /** @use SdkModel<BetaTextEditorCodeExecutionToolResultBlockShape> */
    use SdkModel;

    /** @var 'text_editor_code_execution_tool_result' $type */
    #[Required]
    public string $type = 'text_editor_code_execution_tool_result';

    #[Required]
    public BetaTextEditorCodeExecutionToolResultError|BetaTextEditorCodeExecutionViewResultBlock|BetaTextEditorCodeExecutionCreateResultBlock|BetaTextEditorCodeExecutionStrReplaceResultBlock $content;

    #[Required]
    public string $tool_use_id;

    /**
     * `new BetaTextEditorCodeExecutionToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTextEditorCodeExecutionToolResultBlock::with(content: ..., tool_use_id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaTextEditorCodeExecutionToolResultBlock)
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
     * @param BetaTextEditorCodeExecutionToolResultError|array{
     *   error_code: value-of<ErrorCode>,
     *   error_message: string|null,
     *   type: 'text_editor_code_execution_tool_result_error',
     * }|BetaTextEditorCodeExecutionViewResultBlock|array{
     *   content: string,
     *   file_type: value-of<FileType>,
     *   num_lines: int|null,
     *   start_line: int|null,
     *   total_lines: int|null,
     *   type: 'text_editor_code_execution_view_result',
     * }|BetaTextEditorCodeExecutionCreateResultBlock|array{
     *   is_file_update: bool, type: 'text_editor_code_execution_create_result'
     * }|BetaTextEditorCodeExecutionStrReplaceResultBlock|array{
     *   lines: list<string>|null,
     *   new_lines: int|null,
     *   new_start: int|null,
     *   old_lines: int|null,
     *   old_start: int|null,
     *   type: 'text_editor_code_execution_str_replace_result',
     * } $content
     */
    public static function with(
        BetaTextEditorCodeExecutionToolResultError|array|BetaTextEditorCodeExecutionViewResultBlock|BetaTextEditorCodeExecutionCreateResultBlock|BetaTextEditorCodeExecutionStrReplaceResultBlock $content,
        string $tool_use_id,
    ): self {
        $obj = new self;

        $obj['content'] = $content;
        $obj['tool_use_id'] = $tool_use_id;

        return $obj;
    }

    /**
     * @param BetaTextEditorCodeExecutionToolResultError|array{
     *   error_code: value-of<ErrorCode>,
     *   error_message: string|null,
     *   type: 'text_editor_code_execution_tool_result_error',
     * }|BetaTextEditorCodeExecutionViewResultBlock|array{
     *   content: string,
     *   file_type: value-of<FileType>,
     *   num_lines: int|null,
     *   start_line: int|null,
     *   total_lines: int|null,
     *   type: 'text_editor_code_execution_view_result',
     * }|BetaTextEditorCodeExecutionCreateResultBlock|array{
     *   is_file_update: bool, type: 'text_editor_code_execution_create_result'
     * }|BetaTextEditorCodeExecutionStrReplaceResultBlock|array{
     *   lines: list<string>|null,
     *   new_lines: int|null,
     *   new_start: int|null,
     *   old_lines: int|null,
     *   old_start: int|null,
     *   type: 'text_editor_code_execution_str_replace_result',
     * } $content
     */
    public function withContent(
        BetaTextEditorCodeExecutionToolResultError|array|BetaTextEditorCodeExecutionViewResultBlock|BetaTextEditorCodeExecutionCreateResultBlock|BetaTextEditorCodeExecutionStrReplaceResultBlock $content,
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
}
