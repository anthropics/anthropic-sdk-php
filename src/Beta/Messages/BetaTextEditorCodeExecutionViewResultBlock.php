<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionViewResultBlock\FileType;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaTextEditorCodeExecutionViewResultBlockShape = array{
 *   content: string,
 *   fileType: FileType|value-of<FileType>,
 *   numLines: int|null,
 *   startLine: int|null,
 *   totalLines: int|null,
 *   type: 'text_editor_code_execution_view_result',
 * }
 */
final class BetaTextEditorCodeExecutionViewResultBlock implements BaseModel
{
    /** @use SdkModel<BetaTextEditorCodeExecutionViewResultBlockShape> */
    use SdkModel;

    /** @var 'text_editor_code_execution_view_result' $type */
    #[Required]
    public string $type = 'text_editor_code_execution_view_result';

    #[Required]
    public string $content;

    /** @var value-of<FileType> $fileType */
    #[Required('file_type', enum: FileType::class)]
    public string $fileType;

    #[Required('num_lines')]
    public ?int $numLines;

    #[Required('start_line')]
    public ?int $startLine;

    #[Required('total_lines')]
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
     * @param FileType|value-of<FileType> $fileType
     */
    public static function with(
        string $content,
        FileType|string $fileType,
        ?int $numLines,
        ?int $startLine,
        ?int $totalLines,
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['fileType'] = $fileType;
        $self['numLines'] = $numLines;
        $self['startLine'] = $startLine;
        $self['totalLines'] = $totalLines;

        return $self;
    }

    public function withContent(string $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * @param FileType|value-of<FileType> $fileType
     */
    public function withFileType(FileType|string $fileType): self
    {
        $self = clone $this;
        $self['fileType'] = $fileType;

        return $self;
    }

    public function withNumLines(?int $numLines): self
    {
        $self = clone $this;
        $self['numLines'] = $numLines;

        return $self;
    }

    public function withStartLine(?int $startLine): self
    {
        $self = clone $this;
        $self['startLine'] = $startLine;

        return $self;
    }

    public function withTotalLines(?int $totalLines): self
    {
        $self = clone $this;
        $self['totalLines'] = $totalLines;

        return $self;
    }
}
