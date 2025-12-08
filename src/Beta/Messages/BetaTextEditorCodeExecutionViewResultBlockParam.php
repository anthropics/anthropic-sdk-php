<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionViewResultBlockParam\FileType;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaTextEditorCodeExecutionViewResultBlockParamShape = array{
 *   content: string,
 *   file_type: value-of<FileType>,
 *   type: 'text_editor_code_execution_view_result',
 *   num_lines?: int|null,
 *   start_line?: int|null,
 *   total_lines?: int|null,
 * }
 */
final class BetaTextEditorCodeExecutionViewResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaTextEditorCodeExecutionViewResultBlockParamShape> */
    use SdkModel;

    /** @var 'text_editor_code_execution_view_result' $type */
    #[Required]
    public string $type = 'text_editor_code_execution_view_result';

    #[Required]
    public string $content;

    /** @var value-of<FileType> $file_type */
    #[Required(enum: FileType::class)]
    public string $file_type;

    #[Optional(nullable: true)]
    public ?int $num_lines;

    #[Optional(nullable: true)]
    public ?int $start_line;

    #[Optional(nullable: true)]
    public ?int $total_lines;

    /**
     * `new BetaTextEditorCodeExecutionViewResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTextEditorCodeExecutionViewResultBlockParam::with(
     *   content: ..., file_type: ...
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
     * @param FileType|value-of<FileType> $file_type
     */
    public static function with(
        string $content,
        FileType|string $file_type,
        ?int $num_lines = null,
        ?int $start_line = null,
        ?int $total_lines = null,
    ): self {
        $obj = new self;

        $obj['content'] = $content;
        $obj['file_type'] = $file_type;

        null !== $num_lines && $obj['num_lines'] = $num_lines;
        null !== $start_line && $obj['start_line'] = $start_line;
        null !== $total_lines && $obj['total_lines'] = $total_lines;

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
