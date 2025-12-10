<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaTextEditorCodeExecutionStrReplaceResultBlockShape = array{
 *   lines: list<string>|null,
 *   newLines: int|null,
 *   newStart: int|null,
 *   oldLines: int|null,
 *   oldStart: int|null,
 *   type?: 'text_editor_code_execution_str_replace_result',
 * }
 */
final class BetaTextEditorCodeExecutionStrReplaceResultBlock implements BaseModel
{
    /** @use SdkModel<BetaTextEditorCodeExecutionStrReplaceResultBlockShape> */
    use SdkModel;

    /** @var 'text_editor_code_execution_str_replace_result' $type */
    #[Required]
    public string $type = 'text_editor_code_execution_str_replace_result';

    /** @var list<string>|null $lines */
    #[Required(list: 'string')]
    public ?array $lines;

    #[Required('new_lines')]
    public ?int $newLines;

    #[Required('new_start')]
    public ?int $newStart;

    #[Required('old_lines')]
    public ?int $oldLines;

    #[Required('old_start')]
    public ?int $oldStart;

    /**
     * `new BetaTextEditorCodeExecutionStrReplaceResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTextEditorCodeExecutionStrReplaceResultBlock::with(
     *   lines: ..., newLines: ..., newStart: ..., oldLines: ..., oldStart: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaTextEditorCodeExecutionStrReplaceResultBlock)
     *   ->withLines(...)
     *   ->withNewLines(...)
     *   ->withNewStart(...)
     *   ->withOldLines(...)
     *   ->withOldStart(...)
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
     * @param list<string>|null $lines
     */
    public static function with(
        ?array $lines,
        ?int $newLines,
        ?int $newStart,
        ?int $oldLines,
        ?int $oldStart,
    ): self {
        $obj = new self;

        $obj['lines'] = $lines;
        $obj['newLines'] = $newLines;
        $obj['newStart'] = $newStart;
        $obj['oldLines'] = $oldLines;
        $obj['oldStart'] = $oldStart;

        return $obj;
    }

    /**
     * @param list<string>|null $lines
     */
    public function withLines(?array $lines): self
    {
        $obj = clone $this;
        $obj['lines'] = $lines;

        return $obj;
    }

    public function withNewLines(?int $newLines): self
    {
        $obj = clone $this;
        $obj['newLines'] = $newLines;

        return $obj;
    }

    public function withNewStart(?int $newStart): self
    {
        $obj = clone $this;
        $obj['newStart'] = $newStart;

        return $obj;
    }

    public function withOldLines(?int $oldLines): self
    {
        $obj = clone $this;
        $obj['oldLines'] = $oldLines;

        return $obj;
    }

    public function withOldStart(?int $oldStart): self
    {
        $obj = clone $this;
        $obj['oldStart'] = $oldStart;

        return $obj;
    }
}
