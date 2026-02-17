<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type TextEditorCodeExecutionStrReplaceResultBlockParamShape = array{
 *   type: 'text_editor_code_execution_str_replace_result',
 *   lines?: list<string>|null,
 *   newLines?: int|null,
 *   newStart?: int|null,
 *   oldLines?: int|null,
 *   oldStart?: int|null,
 * }
 */
final class TextEditorCodeExecutionStrReplaceResultBlockParam implements BaseModel
{
    /** @use SdkModel<TextEditorCodeExecutionStrReplaceResultBlockParamShape> */
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
        $self = new self;

        null !== $lines && $self['lines'] = $lines;
        null !== $newLines && $self['newLines'] = $newLines;
        null !== $newStart && $self['newStart'] = $newStart;
        null !== $oldLines && $self['oldLines'] = $oldLines;
        null !== $oldStart && $self['oldStart'] = $oldStart;

        return $self;
    }

    /**
     * @param 'text_editor_code_execution_str_replace_result' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * @param list<string>|null $lines
     */
    public function withLines(?array $lines): self
    {
        $self = clone $this;
        $self['lines'] = $lines;

        return $self;
    }

    public function withNewLines(?int $newLines): self
    {
        $self = clone $this;
        $self['newLines'] = $newLines;

        return $self;
    }

    public function withNewStart(?int $newStart): self
    {
        $self = clone $this;
        $self['newStart'] = $newStart;

        return $self;
    }

    public function withOldLines(?int $oldLines): self
    {
        $self = clone $this;
        $self['oldLines'] = $oldLines;

        return $self;
    }

    public function withOldStart(?int $oldStart): self
    {
        $self = clone $this;
        $self['oldStart'] = $oldStart;

        return $self;
    }
}
