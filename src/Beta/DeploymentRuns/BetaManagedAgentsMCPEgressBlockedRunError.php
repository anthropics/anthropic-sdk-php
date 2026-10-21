<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * An MCP server host used by the deployment's agent is blocked by the environment's network policy.
 *
 * @phpstan-type BetaManagedAgentsMCPEgressBlockedRunErrorShape = array{
 *   message: string, type: 'mcp_egress_blocked_error'
 * }
 */
final class BetaManagedAgentsMCPEgressBlockedRunError implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMCPEgressBlockedRunErrorShape> */
    use SdkModel;

    /** @var 'mcp_egress_blocked_error' $type */
    #[Required(type: new ConstantOf('mcp_egress_blocked_error'))]
    public string $type = 'mcp_egress_blocked_error';

    /**
     * Human-readable error description.
     */
    #[Required]
    public string $message;

    /**
     * `new BetaManagedAgentsMCPEgressBlockedRunError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsMCPEgressBlockedRunError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsMCPEgressBlockedRunError())->withMessage(...)
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
     * @param 'mcp_egress_blocked_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
