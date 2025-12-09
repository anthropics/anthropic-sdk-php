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
 *   fileType: value-of<FileType>,
 *   type?: 'text_editor_code_execution_view_result',
 *   numLines?: int|null,
 *   startLine?: int|null,
 *   totalLines?: int|null,
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

    /** @var value-of<FileType> $fileType */
    #[Required('file_type', enum: FileType::class)]
    public string $fileType;

    #[Optional('num_lines', nullable: true)]
    public ?int $numLines;

    #[Optional('start_line', nullable: true)]
    public ?int $startLine;

    #[Optional('total_lines', nullable: true)]
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

        $obj['content'] = $content;
        $obj['fileType'] = $fileType;

        null !== $numLines && $obj['numLines'] = $numLines;
        null !== $startLine && $obj['startLine'] = $startLine;
        null !== $totalLines && $obj['totalLines'] = $totalLines;

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
        $obj['fileType'] = $fileType;

        return $obj;
    }

    public function withNumLines(?int $numLines): self
    {
        $obj = clone $this;
        $obj['numLines'] = $numLines;

        return $obj;
    }

    public function withStartLine(?int $startLine): self
    {
        $obj = clone $this;
        $obj['startLine'] = $startLine;

        return $obj;
    }

    public function withTotalLines(?int $totalLines): self
    {
        $obj = clone $this;
        $obj['totalLines'] = $totalLines;

        return $obj;
    }
}
