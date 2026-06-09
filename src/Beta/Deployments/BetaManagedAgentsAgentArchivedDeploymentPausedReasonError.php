<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Beta\Deployments\BetaManagedAgentsAgentArchivedDeploymentPausedReasonError\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The deployment's agent was archived.
 *
 * @phpstan-type BetaManagedAgentsAgentArchivedDeploymentPausedReasonErrorShape = array{
 *   type: Type|value-of<Type>
 * }
 */
final class BetaManagedAgentsAgentArchivedDeploymentPausedReasonError implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAgentArchivedDeploymentPausedReasonErrorShape> */
    use SdkModel;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsAgentArchivedDeploymentPausedReasonError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAgentArchivedDeploymentPausedReasonError::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAgentArchivedDeploymentPausedReasonError)->withType(...)
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
     *
     * @param Type|value-of<Type> $type
     */
    public static function with(Type|string $type): self
    {
        $self = new self;

        $self['type'] = $type;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
