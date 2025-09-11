<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionViewResultBlockParam\FileType;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_text_editor_code_execution_view_result_block_param = array{
 *   content: string,
 *   fileType: value-of<FileType>,
 *   type: string,
 *   numLines?: int|null,
 *   startLine?: int|null,
 *   totalLines?: int|null,
 * }
 */
final class BetaTextEditorCodeExecutionViewResultBlockParam implements BaseModel
{
    /** @use SdkModel<beta_text_editor_code_execution_view_result_block_param> */
    use SdkModel;

    #[Api]
    public string $type = 'text_editor_code_execution_view_result';

    #[Api]
    public string $content;

    /** @var value-of<FileType> $fileType */
    #[Api('file_type', enum: FileType::class)]
    public string $fileType;

    #[Api('num_lines', nullable: true, optional: true)]
    public ?int $numLines;

    #[Api('start_line', nullable: true, optional: true)]
    public ?int $startLine;

    #[Api('total_lines', nullable: true, optional: true)]
    public ?int $totalLines;

    /**
     * `new BetaTextEditorCodeExecutionViewResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTextEditorCodeExecutionViewResultBlockParam::with(
     *   content: ..., fileType: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaTextEditorCodeExecutionViewResultBlockParam)
     *   ->withContent(...)
     *   ->withFileType(...)
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
     * @param FileType|value-of<FileType> $fileType
     */
    public static function with(
        string $content,
        FileType|string $fileType,
        ?int $numLines = null,
        ?int $startLine = null,
        ?int $totalLines = null,
    ): self {
        $obj = new self;

        $obj->content = $content;
        $obj->fileType = $fileType instanceof FileType ? $fileType->value : $fileType;

        null !== $numLines && $obj->numLines = $numLines;
        null !== $startLine && $obj->startLine = $startLine;
        null !== $totalLines && $obj->totalLines = $totalLines;

        return $obj;
    }

    public function withContent(string $content): self
    {
        $obj = clone $this;
        $obj->content = $content;

        return $obj;
    }

    /**
     * @param FileType|value-of<FileType> $fileType
     */
    public function withFileType(FileType|string $fileType): self
    {
        $obj = clone $this;
        $obj->fileType = $fileType instanceof FileType ? $fileType->value : $fileType;

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
