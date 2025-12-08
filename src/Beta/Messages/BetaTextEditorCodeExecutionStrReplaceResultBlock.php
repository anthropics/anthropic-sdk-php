<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaTextEditorCodeExecutionStrReplaceResultBlockShape = array{
 *   lines: list<string>|null,
 *   new_lines: int|null,
 *   new_start: int|null,
 *   old_lines: int|null,
 *   old_start: int|null,
 *   type: 'text_editor_code_execution_str_replace_result',
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

    #[Required]
    public ?int $new_lines;

    #[Required]
    public ?int $new_start;

    #[Required]
    public ?int $old_lines;

    #[Required]
    public ?int $old_start;

    /**
     * `new BetaTextEditorCodeExecutionStrReplaceResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTextEditorCodeExecutionStrReplaceResultBlock::with(
     *   lines: ..., new_lines: ..., new_start: ..., old_lines: ..., old_start: ...
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
        ?int $new_lines,
        ?int $new_start,
        ?int $old_lines,
        ?int $old_start,
    ): self {
        $obj = new self;

        $obj['lines'] = $lines;
        $obj['new_lines'] = $new_lines;
        $obj['new_start'] = $new_start;
        $obj['old_lines'] = $old_lines;
        $obj['old_start'] = $old_start;

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
        $obj['new_lines'] = $newLines;

        return $obj;
    }

    public function withNewStart(?int $newStart): self
    {
        $obj = clone $this;
        $obj['new_start'] = $newStart;

        return $obj;
    }

    public function withOldLines(?int $oldLines): self
    {
        $obj = clone $this;
        $obj['old_lines'] = $oldLines;

        return $obj;
    }

    public function withOldStart(?int $oldStart): self
    {
        $obj = clone $this;
        $obj['old_start'] = $oldStart;

        return $obj;
    }
}
