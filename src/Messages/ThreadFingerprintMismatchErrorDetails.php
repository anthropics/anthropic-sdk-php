<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A field that must stay the same across a Thread's turns differs from the value stored with the Thread; the message names each such field. Send the stored values, or replay the full conversation with `thread: {"type": "create"}` to change them.
 *
 * @phpstan-type ThreadFingerprintMismatchErrorDetailsShape = array{
 *   errorCode: 'thread_fingerprint_mismatch'
 * }
 */
final class ThreadFingerprintMismatchErrorDetails implements BaseModel
{
    /** @use SdkModel<ThreadFingerprintMismatchErrorDetailsShape> */
    use SdkModel;

    /** @var 'thread_fingerprint_mismatch' $errorCode */
    #[Required('error_code', type: new ConstantOf('thread_fingerprint_mismatch'))]
    public string $errorCode = 'thread_fingerprint_mismatch';

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
     * @param 'thread_fingerprint_mismatch' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
