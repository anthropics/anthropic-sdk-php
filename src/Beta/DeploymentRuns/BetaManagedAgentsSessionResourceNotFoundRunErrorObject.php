<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A referenced resource no longer exists and its kind was not reported.
 *
 * @phpstan-type BetaManagedAgentsSessionResourceNotFoundRunErrorObjectShape = array{
 *   message: string, type: 'session_resource_not_found_error'
 * }
 */
class BetaManagedAgentsSessionResourceNotFoundRunErrorObject implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSessionResourceNotFoundRunErrorObjectShape> */
    use SdkModel;

    /** @var 'session_resource_not_found_error' $type */
    #[Required(type: new ConstantOf('session_resource_not_found_error'))]
    public string $type = 'session_resource_not_found_error';

    /**
     * Human-readable error description.
     */
    #[Required]
    public string $message;

    /**
     * `new BetaManagedAgentsSessionResourceNotFoundRunErrorObject()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsSessionResourceNotFoundRunErrorObject::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsSessionResourceNotFoundRunErrorObject())->withMessage(...)
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
     * @param 'session_resource_not_found_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}

class_alias(
    BetaManagedAgentsSessionResourceNotFoundRunErrorObject::class,
    'Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSessionResourceNotFoundRunError',
);
