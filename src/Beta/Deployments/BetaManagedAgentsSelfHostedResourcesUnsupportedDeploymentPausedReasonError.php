<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The deployment configures resources, but its environment is self-hosted and cannot mount them.
 *
 * @phpstan-type BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonErrorShape = array{
 *   type: 'self_hosted_resources_unsupported_error'
 * }
 */
final class BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonError implements BaseModel
{
    /**
     * @use SdkModel<BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonErrorShape>
     */
    use SdkModel;

    /** @var 'self_hosted_resources_unsupported_error' $type */
    #[Required(type: new ConstantOf('self_hosted_resources_unsupported_error'))]
    public string $type = 'self_hosted_resources_unsupported_error';

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
     * @param 'self_hosted_resources_unsupported_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
