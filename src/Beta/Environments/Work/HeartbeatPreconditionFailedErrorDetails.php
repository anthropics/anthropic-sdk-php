<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\Work;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * `expected_last_heartbeat` does not match the stored heartbeat, so another worker may hold the lease.
 *
 * @phpstan-import-type WorkLeaseStateShape from \Anthropic\Beta\Environments\Work\WorkLeaseState
 *
 * @phpstan-type HeartbeatPreconditionFailedErrorDetailsShape = array{
 *   currentState: WorkLeaseState|WorkLeaseStateShape,
 *   errorCode: 'heartbeat_precondition_failed',
 * }
 */
final class HeartbeatPreconditionFailedErrorDetails implements BaseModel
{
    /** @use SdkModel<HeartbeatPreconditionFailedErrorDetailsShape> */
    use SdkModel;

    /** @var 'heartbeat_precondition_failed' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('heartbeat_precondition_failed')
    )]
    public string $errorCode = 'heartbeat_precondition_failed';

    /**
     * The lease as the server holds it.
     */
    #[Required('current_state')]
    public WorkLeaseState $currentState;

    /**
     * `new HeartbeatPreconditionFailedErrorDetails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * HeartbeatPreconditionFailedErrorDetails::with(currentState: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new HeartbeatPreconditionFailedErrorDetails())->withCurrentState(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param WorkLeaseState|WorkLeaseStateShape $currentState
     */
    public static function with(WorkLeaseState|array $currentState): self
    {
        $self = new self;

        $self['currentState'] = $currentState;

        return $self;
    }

    /**
     * The lease as the server holds it.
     *
     * @param WorkLeaseState|WorkLeaseStateShape $currentState
     */
    public function withCurrentState(WorkLeaseState|array $currentState): self
    {
        $self = clone $this;
        $self['currentState'] = $currentState;

        return $self;
    }

    /**
     * @param 'heartbeat_precondition_failed' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
