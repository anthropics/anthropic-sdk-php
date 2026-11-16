<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The deployment's environment no longer exists.
 *
 * @phpstan-type BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonErrorObjectShape = array{
 *   type: 'environment_not_found_error'
 * }
 */
class BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonErrorObject implements BaseModel
{
    /**
     * @use SdkModel<BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonErrorObjectShape>
     */
    use SdkModel;

    /** @var 'environment_not_found_error' $type */
    #[Required(type: new ConstantOf('environment_not_found_error'))]
    public string $type = 'environment_not_found_error';

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
     * @param 'environment_not_found_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}

class_alias(
    BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonErrorObject::class,
    'Anthropic\Beta\Deployments\BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonError',
);
