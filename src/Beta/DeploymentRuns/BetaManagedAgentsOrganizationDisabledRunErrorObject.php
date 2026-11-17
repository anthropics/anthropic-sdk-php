<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The deployment's organization is disabled.
 *
 * @phpstan-type BetaManagedAgentsOrganizationDisabledRunErrorObjectShape = array{
 *   message: string, type: 'organization_disabled_error'
 * }
 */
class BetaManagedAgentsOrganizationDisabledRunErrorObject implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsOrganizationDisabledRunErrorObjectShape> */
    use SdkModel;

    /** @var 'organization_disabled_error' $type */
    #[Required(type: new ConstantOf('organization_disabled_error'))]
    public string $type = 'organization_disabled_error';

    /**
     * Human-readable error description.
     */
    #[Required]
    public string $message;

    /**
     * `new BetaManagedAgentsOrganizationDisabledRunErrorObject()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsOrganizationDisabledRunErrorObject::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsOrganizationDisabledRunErrorObject())->withMessage(...)
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
     * @param 'organization_disabled_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}

class_alias(
    BetaManagedAgentsOrganizationDisabledRunErrorObject::class,
    'Anthropic\Beta\DeploymentRuns\BetaManagedAgentsOrganizationDisabledRunError',
);
