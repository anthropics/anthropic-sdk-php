<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * `messages` holds more than one `compaction` block with content. Send only the block the conversation returned last.
 *
 * @phpstan-type CompactionBlockAmbiguousErrorDetailsShape = array{
 *   errorCode: 'compaction_block_ambiguous'
 * }
 */
final class CompactionBlockAmbiguousErrorDetails implements BaseModel
{
    /** @use SdkModel<CompactionBlockAmbiguousErrorDetailsShape> */
    use SdkModel;

    /** @var 'compaction_block_ambiguous' $errorCode */
    #[Required('error_code', type: new ConstantOf('compaction_block_ambiguous'))]
    public string $errorCode = 'compaction_block_ambiguous';

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
     * @param 'compaction_block_ambiguous' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
