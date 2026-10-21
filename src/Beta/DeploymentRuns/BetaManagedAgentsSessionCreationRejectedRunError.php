<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The session create request was rejected with a non-retryable validation error.
 *
 * @phpstan-type BetaManagedAgentsSessionCreationRejectedRunErrorShape = array{
 *   message: string, type: 'session_creation_rejected_error'
 * }
 */
final class BetaManagedAgentsSessionCreationRejectedRunError implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSessionCreationRejectedRunErrorShape> */
    use SdkModel;

    /** @var 'session_creation_rejected_error' $type */
    #[Required(type: new ConstantOf('session_creation_rejected_error'))]
    public string $type = 'session_creation_rejected_error';

    /**
     * Human-readable error description.
     */
    #[Required]
    public string $message;

    /**
     * `new BetaManagedAgentsSessionCreationRejectedRunError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsSessionCreationRejectedRunError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsSessionCreationRejectedRunError())->withMessage(...)
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
     */
    public static function with(string $message): self
    {
        $self = new self;

        $self['message'] = $message;

        return $self;
    }

    /**
     * Human-readable error description.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * @param 'session_creation_rejected_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
