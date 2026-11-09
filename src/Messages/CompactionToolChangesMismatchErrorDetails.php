<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The `compaction` block's `tool_changes` differs from what was returned with the block.
 *
 * @phpstan-type CompactionToolChangesMismatchErrorDetailsShape = array{
 *   errorCode: 'compaction_tool_changes_mismatch'
 * }
 */
final class CompactionToolChangesMismatchErrorDetails implements BaseModel
{
    /** @use SdkModel<CompactionToolChangesMismatchErrorDetailsShape> */
    use SdkModel;

    /** @var 'compaction_tool_changes_mismatch' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('compaction_tool_changes_mismatch')
    )]
    public string $errorCode = 'compaction_tool_changes_mismatch';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }

    /**
     * @param 'compaction_tool_changes_mismatch' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
