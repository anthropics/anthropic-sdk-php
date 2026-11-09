<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Another request is still continuing from the same `previous_message_id`. Wait for it to complete and continue from its response `id`, or replay the full conversation with `thread: {"type": "create"}`.
 *
 * @phpstan-type ThreadContinueInFlightErrorDetailsShape = array{
 *   errorCode: 'thread_continue_in_flight'
 * }
 */
final class ThreadContinueInFlightErrorDetails implements BaseModel
{
    /** @use SdkModel<ThreadContinueInFlightErrorDetailsShape> */
    use SdkModel;

    /** @var 'thread_continue_in_flight' $errorCode */
    #[Required('error_code', type: new ConstantOf('thread_continue_in_flight'))]
    public string $errorCode = 'thread_continue_in_flight';

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
     * @param 'thread_continue_in_flight' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
