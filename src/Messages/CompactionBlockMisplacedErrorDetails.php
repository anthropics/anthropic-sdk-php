<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The `compaction` block is not the first block of the conversation, or is in a `system` message.
 *
 * @phpstan-type CompactionBlockMisplacedErrorDetailsShape = array{
 *   errorCode: 'compaction_block_misplaced'
 * }
 */
final class CompactionBlockMisplacedErrorDetails implements BaseModel
{
    /** @use SdkModel<CompactionBlockMisplacedErrorDetailsShape> */
    use SdkModel;

    /** @var 'compaction_block_misplaced' $errorCode */
    #[Required('error_code', type: new ConstantOf('compaction_block_misplaced'))]
    public string $errorCode = 'compaction_block_misplaced';

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
     * @param 'compaction_block_misplaced' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
