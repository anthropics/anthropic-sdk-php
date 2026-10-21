<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * An MCP server host used by the deployment's agent is blocked by the environment's network policy.
 *
 * @phpstan-type BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonErrorShape = array{
 *   type: 'mcp_egress_blocked_error'
 * }
 */
final class BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonError implements BaseModel
{
    /**
     * @use SdkModel<BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonErrorShape>
     */
    use SdkModel;

    /** @var 'mcp_egress_blocked_error' $type */
    #[Required(type: new ConstantOf('mcp_egress_blocked_error'))]
    public string $type = 'mcp_egress_blocked_error';

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
     * @param 'mcp_egress_blocked_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
