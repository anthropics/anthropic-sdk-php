<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The deployment's agent was archived.
 *
 * @phpstan-type BetaManagedAgentsAgentArchivedDeploymentPausedReasonErrorShape = array{
 *   type: 'agent_archived_error'
 * }
 */
final class BetaManagedAgentsAgentArchivedDeploymentPausedReasonError implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAgentArchivedDeploymentPausedReasonErrorShape> */
    use SdkModel;

    /** @var 'agent_archived_error' $type */
    #[Required(type: new ConstantOf('agent_archived_error'))]
    public string $type = 'agent_archived_error';

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
     * @param 'agent_archived_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
