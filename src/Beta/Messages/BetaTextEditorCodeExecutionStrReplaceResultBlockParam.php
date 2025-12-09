<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaTextEditorCodeExecutionStrReplaceResultBlockParamShape = array{
 *   type?: 'text_editor_code_execution_str_replace_result',
 *   lines?: list<string>|null,
 *   newLines?: int|null,
 *   newStart?: int|null,
 *   oldLines?: int|null,
 *   oldStart?: int|null,
 * }
 */
final class BetaTextEditorCodeExecutionStrReplaceResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaTextEditorCodeExecutionStrReplaceResultBlockParamShape> */
    use SdkModel;

    /** @var 'text_editor_code_execution_str_replace_result' $type */
    #[Required]
    public string $type = 'text_editor_code_execution_str_replace_result';

    /** @var list<string>|null $lines */
    #[Optional(list: 'string', nullable: true)]
    public ?array $lines;

    #[Optional('new_lines', nullable: true)]
    public ?int $newLines;

    #[Optional('new_start', nullable: true)]
    public ?int $newStart;

    #[Optional('old_lines', nullable: true)]
    public ?int $oldLines;

    #[Optional('old_start', nullable: true)]
    public ?int $oldStart;

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
        ?array $lines = null,
        ?int $newLines = null,
        ?int $newStart = null,
        ?int $oldLines = null,
        ?int $oldStart = null,
    ): self {
        $obj = new self;

        null !== $lines && $obj['lines'] = $lines;
        null !== $newLines && $obj['newLines'] = $newLines;
        null !== $newStart && $obj['newStart'] = $newStart;
        null !== $oldLines && $obj['oldLines'] = $oldLines;
        null !== $oldStart && $obj['oldStart'] = $oldStart;

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
