<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The deployment's agent was archived.
 *
 * @phpstan-type BetaManagedAgentsAgentArchivedRunErrorObjectShape = array{
 *   message: string, type: 'agent_archived_error'
 * }
 */
class BetaManagedAgentsAgentArchivedRunErrorObject implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAgentArchivedRunErrorObjectShape> */
    use SdkModel;

    /** @var 'agent_archived_error' $type */
    #[Required(type: new ConstantOf('agent_archived_error'))]
    public string $type = 'agent_archived_error';

    /**
     * Human-readable error description.
     */
    #[Required]
    public string $message;

    /**
     * `new BetaManagedAgentsAgentArchivedRunErrorObject()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAgentArchivedRunErrorObject::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAgentArchivedRunErrorObject())->withMessage(...)
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
     * @param 'agent_archived_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}

class_alias(
    BetaManagedAgentsAgentArchivedRunErrorObject::class,
    'Anthropic\Beta\DeploymentRuns\BetaManagedAgentsAgentArchivedRunError',
);
