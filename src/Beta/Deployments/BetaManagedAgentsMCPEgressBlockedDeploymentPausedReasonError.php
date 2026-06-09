<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Beta\Deployments\BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonError\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * An MCP server host used by the deployment's agent is blocked by the environment's network policy.
 *
 * @phpstan-type BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonErrorShape = array{
 *   type: Type|value-of<Type>
 * }
 */
final class BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonError implements BaseModel
{
    /**
     * @use SdkModel<BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonErrorShape>
     */
    use SdkModel;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonError::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonError)
     *   ->withType(...)
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
