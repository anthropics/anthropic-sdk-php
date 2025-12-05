<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaTextEditorCodeExecutionStrReplaceResultBlockParamShape = array{
 *   type: 'text_editor_code_execution_str_replace_result',
 *   lines?: list<string>|null,
 *   new_lines?: int|null,
 *   new_start?: int|null,
 *   old_lines?: int|null,
 *   old_start?: int|null,
 * }
 */
final class BetaTextEditorCodeExecutionStrReplaceResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaTextEditorCodeExecutionStrReplaceResultBlockParamShape> */
    use SdkModel;

    /** @var 'text_editor_code_execution_str_replace_result' $type */
    #[Api]
    public string $type = 'text_editor_code_execution_str_replace_result';

    /** @var list<string>|null $lines */
    #[Api(list: 'string', nullable: true, optional: true)]
    public ?array $lines;

    #[Api(nullable: true, optional: true)]
    public ?int $new_lines;

    #[Api(nullable: true, optional: true)]
    public ?int $new_start;

    #[Api(nullable: true, optional: true)]
    public ?int $old_lines;

    #[Api(nullable: true, optional: true)]
    public ?int $old_start;

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
        ?int $new_lines = null,
        ?int $new_start = null,
        ?int $old_lines = null,
        ?int $old_start = null,
    ): self {
        $obj = new self;

        null !== $lines && $obj['lines'] = $lines;
        null !== $new_lines && $obj['new_lines'] = $new_lines;
        null !== $new_start && $obj['new_start'] = $new_start;
        null !== $old_lines && $obj['old_lines'] = $old_lines;
        null !== $old_start && $obj['old_start'] = $old_start;

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
