<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The deployment's environment was archived.
 *
 * @phpstan-type BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonErrorObjectShape = array{
 *   type: 'environment_archived_error'
 * }
 */
class BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonErrorObject implements BaseModel
{
    /**
     * @use SdkModel<BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonErrorObjectShape>
     */
    use SdkModel;

    /** @var 'environment_archived_error' $type */
    #[Required(type: new ConstantOf('environment_archived_error'))]
    public string $type = 'environment_archived_error';

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
     * @param 'environment_archived_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}

class_alias(
    BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonErrorObject::class,
    'Anthropic\Beta\Deployments\BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonError',
);
