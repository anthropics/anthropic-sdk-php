<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The deployment configures resources, but its environment is self-hosted and cannot mount them.
 *
 * @phpstan-type BetaManagedAgentsSelfHostedResourcesUnsupportedRunErrorShape = array{
 *   message: string, type: 'self_hosted_resources_unsupported_error'
 * }
 */
final class BetaManagedAgentsSelfHostedResourcesUnsupportedRunError implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSelfHostedResourcesUnsupportedRunErrorShape> */
    use SdkModel;

    /** @var 'self_hosted_resources_unsupported_error' $type */
    #[Required(type: new ConstantOf('self_hosted_resources_unsupported_error'))]
    public string $type = 'self_hosted_resources_unsupported_error';

    /**
     * Human-readable error description.
     */
    #[Required]
    public string $message;

    /**
     * `new BetaManagedAgentsSelfHostedResourcesUnsupportedRunError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsSelfHostedResourcesUnsupportedRunError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsSelfHostedResourcesUnsupportedRunError())
     *   ->withMessage(...)
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
     * @param 'self_hosted_resources_unsupported_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
