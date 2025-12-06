<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionViewResultBlock\FileType;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaTextEditorCodeExecutionViewResultBlockShape = array{
 *   content: string,
 *   file_type: value-of<FileType>,
 *   num_lines: int|null,
 *   start_line: int|null,
 *   total_lines: int|null,
 *   type: 'text_editor_code_execution_view_result',
 * }
 */
final class BetaTextEditorCodeExecutionViewResultBlock implements BaseModel
{
    /** @use SdkModel<BetaTextEditorCodeExecutionViewResultBlockShape> */
    use SdkModel;

    /** @var 'text_editor_code_execution_view_result' $type */
    #[Api]
    public string $type = 'text_editor_code_execution_view_result';

    #[Api]
    public string $content;

    /** @var value-of<FileType> $file_type */
    #[Api(enum: FileType::class)]
    public string $file_type;

    #[Api]
    public ?int $num_lines;

    #[Api]
    public ?int $start_line;

    #[Api]
    public ?int $total_lines;

    /**
     * `new BetaTextEditorCodeExecutionViewResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTextEditorCodeExecutionViewResultBlock::with(
     *   content: ...,
     *   file_type: ...,
     *   num_lines: ...,
     *   start_line: ...,
     *   total_lines: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaTextEditorCodeExecutionViewResultBlock)
     *   ->withContent(...)
     *   ->withFileType(...)
     *   ->withNumLines(...)
     *   ->withStartLine(...)
     *   ->withTotalLines(...)
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
     * @param FileType|value-of<FileType> $file_type
     */
    public static function with(
        string $content,
        FileType|string $file_type,
        ?int $num_lines,
        ?int $start_line,
        ?int $total_lines,
    ): self {
        $obj = new self;

        $obj['content'] = $content;
        $obj['file_type'] = $file_type;
        $obj['num_lines'] = $num_lines;
        $obj['start_line'] = $start_line;
        $obj['total_lines'] = $total_lines;

        return $obj;
    }

    public function withContent(string $content): self
    {
        $obj = clone $this;
        $obj['content'] = $content;

        return $obj;
    }

    /**
     * @param FileType|value-of<FileType> $fileType
     */
    public function withFileType(FileType|string $fileType): self
    {
        $obj = clone $this;
        $obj['file_type'] = $fileType;

        return $obj;
    }

    public function withNumLines(?int $numLines): self
    {
        $obj = clone $this;
        $obj['num_lines'] = $numLines;

        return $obj;
    }

    public function withStartLine(?int $startLine): self
    {
        $obj = clone $this;
        $obj['start_line'] = $startLine;

        return $obj;
    }

    public function withTotalLines(?int $totalLines): self
    {
        $obj = clone $this;
        $obj['total_lines'] = $totalLines;

        return $obj;
    }
}
