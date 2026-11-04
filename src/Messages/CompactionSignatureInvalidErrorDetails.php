<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The `compaction` block's `signature` does not verify.
 *
 * @phpstan-type CompactionSignatureInvalidErrorDetailsShape = array{
 *   errorCode: 'compaction_signature_invalid'
 * }
 */
final class CompactionSignatureInvalidErrorDetails implements BaseModel
{
    /** @use SdkModel<CompactionSignatureInvalidErrorDetailsShape> */
    use SdkModel;

    /** @var 'compaction_signature_invalid' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('compaction_signature_invalid')
    )]
    public string $errorCode = 'compaction_signature_invalid';

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
     * @param 'compaction_signature_invalid' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
