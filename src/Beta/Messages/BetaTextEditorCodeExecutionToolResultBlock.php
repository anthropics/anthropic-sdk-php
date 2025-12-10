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
 *   toolUseID: string,
 *   type?: 'text_editor_code_execution_tool_result',
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

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * `new BetaTextEditorCodeExecutionToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTextEditorCodeExecutionToolResultBlock::with(content: ..., toolUseID: ...)
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
     *   errorCode: value-of<ErrorCode>,
     *   errorMessage: string|null,
     *   type?: 'text_editor_code_execution_tool_result_error',
     * }|BetaTextEditorCodeExecutionViewResultBlock|array{
     *   content: string,
     *   fileType: value-of<FileType>,
     *   numLines: int|null,
     *   startLine: int|null,
     *   totalLines: int|null,
     *   type?: 'text_editor_code_execution_view_result',
     * }|BetaTextEditorCodeExecutionCreateResultBlock|array{
     *   isFileUpdate: bool, type?: 'text_editor_code_execution_create_result'
     * }|BetaTextEditorCodeExecutionStrReplaceResultBlock|array{
     *   lines: list<string>|null,
     *   newLines: int|null,
     *   newStart: int|null,
     *   oldLines: int|null,
     *   oldStart: int|null,
     *   type?: 'text_editor_code_execution_str_replace_result',
     * } $content
     */
    public static function with(
        BetaTextEditorCodeExecutionToolResultError|array|BetaTextEditorCodeExecutionViewResultBlock|BetaTextEditorCodeExecutionCreateResultBlock|BetaTextEditorCodeExecutionStrReplaceResultBlock $content,
        string $toolUseID,
    ): self {
        $obj = new self;

        $obj['content'] = $content;
        $obj['toolUseID'] = $toolUseID;

        return $obj;
    }

    /**
     * @param BetaTextEditorCodeExecutionToolResultError|array{
     *   errorCode: value-of<ErrorCode>,
     *   errorMessage: string|null,
     *   type?: 'text_editor_code_execution_tool_result_error',
     * }|BetaTextEditorCodeExecutionViewResultBlock|array{
     *   content: string,
     *   fileType: value-of<FileType>,
     *   numLines: int|null,
     *   startLine: int|null,
     *   totalLines: int|null,
     *   type?: 'text_editor_code_execution_view_result',
     * }|BetaTextEditorCodeExecutionCreateResultBlock|array{
     *   isFileUpdate: bool, type?: 'text_editor_code_execution_create_result'
     * }|BetaTextEditorCodeExecutionStrReplaceResultBlock|array{
     *   lines: list<string>|null,
     *   newLines: int|null,
     *   newStart: int|null,
     *   oldLines: int|null,
     *   oldStart: int|null,
     *   type?: 'text_editor_code_execution_str_replace_result',
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
        $obj['toolUseID'] = $toolUseID;

        return $obj;
    }
}
