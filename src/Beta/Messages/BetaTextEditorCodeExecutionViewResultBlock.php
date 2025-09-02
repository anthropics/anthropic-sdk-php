<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionViewResultBlock\FileType;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_text_editor_code_execution_view_result_block = array{
 *   content: string,
 *   fileType: FileType::*,
 *   numLines: int|null,
 *   startLine: int|null,
 *   totalLines: int|null,
 *   type: string,
 * }
 */
final class BetaTextEditorCodeExecutionViewResultBlock implements BaseModel
{
    /** @use SdkModel<beta_text_editor_code_execution_view_result_block> */
    use SdkModel;

    #[Api]
    public string $type = 'text_editor_code_execution_view_result';

    #[Api]
    public string $content;

    /** @var FileType::* $fileType */
    #[Api('file_type', enum: FileType::class)]
    public string $fileType;

    #[Api('num_lines')]
    public ?int $numLines;

    #[Api('start_line')]
    public ?int $startLine;

    #[Api('total_lines')]
    public ?int $totalLines;

    /**
     * `new BetaTextEditorCodeExecutionViewResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTextEditorCodeExecutionViewResultBlock::with(
     *   content: ..., fileType: ..., numLines: ..., startLine: ..., totalLines: ...
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
     * @param FileType::* $fileType
     */
    public static function with(
        string $content,
        string $fileType,
        ?int $numLines,
        ?int $startLine,
        ?int $totalLines,
    ): self {
        $obj = new self;

        $obj->content = $content;
        $obj->fileType = $fileType;
        $obj->numLines = $numLines;
        $obj->startLine = $startLine;
        $obj->totalLines = $totalLines;

        return $obj;
    }

    public function withContent(string $content): self
    {
        $obj = clone $this;
        $obj->content = $content;

        return $obj;
    }

    /**
     * @param FileType::* $fileType
     */
    public function withFileType(string $fileType): self
    {
        $obj = clone $this;
        $obj->fileType = $fileType;

        return $obj;
    }

    public function withNumLines(?int $numLines): self
    {
        $obj = clone $this;
        $obj->numLines = $numLines;

        return $obj;
    }

    public function withStartLine(?int $startLine): self
    {
        $obj = clone $this;
        $obj->startLine = $startLine;

        return $obj;
    }

    public function withTotalLines(?int $totalLines): self
    {
        $obj = clone $this;
        $obj->totalLines = $totalLines;

        return $obj;
    }
}
