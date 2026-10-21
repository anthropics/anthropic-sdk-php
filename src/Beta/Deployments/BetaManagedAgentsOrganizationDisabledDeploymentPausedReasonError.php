<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The deployment's organization is disabled.
 *
 * @phpstan-type BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonErrorShape = array{
 *   type: 'organization_disabled_error'
 * }
 */
final class BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonError implements BaseModel
{
    /**
     * @use SdkModel<BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonErrorShape>
     */
    use SdkModel;

    /** @var 'organization_disabled_error' $type */
    #[Required(type: new ConstantOf('organization_disabled_error'))]
    public string $type = 'organization_disabled_error';

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
     * @param 'organization_disabled_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
