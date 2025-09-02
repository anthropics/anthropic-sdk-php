<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_text_editor_code_execution_str_replace_result_block_param = array{
 *   type: string,
 *   lines?: list<string>|null,
 *   newLines?: int|null,
 *   newStart?: int|null,
 *   oldLines?: int|null,
 *   oldStart?: int|null,
 * }
 */
final class BetaTextEditorCodeExecutionStrReplaceResultBlockParam implements BaseModel
{
    /**
     * @use SdkModel<beta_text_editor_code_execution_str_replace_result_block_param>
     */
    use SdkModel;

    #[Api]
    public string $type = 'text_editor_code_execution_str_replace_result';

    /** @var list<string>|null $lines */
    #[Api(list: 'string', nullable: true, optional: true)]
    public ?array $lines;

    #[Api('new_lines', nullable: true, optional: true)]
    public ?int $newLines;

    #[Api('new_start', nullable: true, optional: true)]
    public ?int $newStart;

    #[Api('old_lines', nullable: true, optional: true)]
    public ?int $oldLines;

    #[Api('old_start', nullable: true, optional: true)]
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

        null !== $lines && $obj->lines = $lines;
        null !== $newLines && $obj->newLines = $newLines;
        null !== $newStart && $obj->newStart = $newStart;
        null !== $oldLines && $obj->oldLines = $oldLines;
        null !== $oldStart && $obj->oldStart = $oldStart;

        return $obj;
    }

    /**
     * @param list<string>|null $lines
     */
    public function withLines(?array $lines): self
    {
        $obj = clone $this;
        $obj->lines = $lines;

        return $obj;
    }

    public function withNewLines(?int $newLines): self
    {
        $obj = clone $this;
        $obj->newLines = $newLines;

        return $obj;
    }

    public function withNewStart(?int $newStart): self
    {
        $obj = clone $this;
        $obj->newStart = $newStart;

        return $obj;
    }

    public function withOldLines(?int $oldLines): self
    {
        $obj = clone $this;
        $obj->oldLines = $oldLines;

        return $obj;
    }

    public function withOldStart(?int $oldStart): self
    {
        $obj = clone $this;
        $obj->oldStart = $oldStart;

        return $obj;
    }
}
