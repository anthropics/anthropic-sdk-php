<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * No usable Thread state was found for `previous_message_id`. Replay the full conversation with `thread: {"type": "create"}` to start a new Thread.
 *
 * @phpstan-type ThreadNotFoundErrorDetailsShape = array{
 *   errorCode: 'thread_not_found'
 * }
 */
final class ThreadNotFoundErrorDetails implements BaseModel
{
    /** @use SdkModel<ThreadNotFoundErrorDetailsShape> */
    use SdkModel;

    /** @var 'thread_not_found' $errorCode */
    #[Required('error_code', type: new ConstantOf('thread_not_found'))]
    public string $errorCode = 'thread_not_found';

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
     * @param 'thread_not_found' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
