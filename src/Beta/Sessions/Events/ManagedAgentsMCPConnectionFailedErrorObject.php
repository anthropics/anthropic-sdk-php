<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsMCPConnectionFailedErrorObject\RetryStatus;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Failed to connect to an MCP server.
 *
 * @phpstan-import-type RetryStatusShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsMCPConnectionFailedErrorObject\RetryStatus
 * @phpstan-import-type RetryStatusVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsMCPConnectionFailedErrorObject\RetryStatus
 *
 * @phpstan-type ManagedAgentsMCPConnectionFailedErrorObjectShape = array{
 *   mcpServerName: string,
 *   message: string,
 *   retryStatus: RetryStatusShape,
 *   type: 'mcp_connection_failed_error',
 * }
 */
class ManagedAgentsMCPConnectionFailedErrorObject implements BaseModel
{
    /** @use SdkModel<ManagedAgentsMCPConnectionFailedErrorObjectShape> */
    use SdkModel;

    /** @var 'mcp_connection_failed_error' $type */
    #[Required(type: new ConstantOf('mcp_connection_failed_error'))]
    public string $type = 'mcp_connection_failed_error';

    /**
     * Name of the MCP server that failed to connect.
     */
    #[Required('mcp_server_name')]
    public string $mcpServerName;

    /**
     * Human-readable error description.
     */
    #[Required]
    public string $message;

    /**
     * What the client should do next.
     *
     * @var RetryStatusVariants $retryStatus
     */
    #[Required('retry_status', union: RetryStatus::class)]
    public ManagedAgentsRetryStatusRetrying|ManagedAgentsRetryStatusExhausted|ManagedAgentsRetryStatusTerminal $retryStatus;

    /**
     * `new ManagedAgentsMCPConnectionFailedErrorObject()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsMCPConnectionFailedErrorObject::with(
     *   mcpServerName: ..., message: ..., retryStatus: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsMCPConnectionFailedErrorObject())
     *   ->withMCPServerName(...)
     *   ->withMessage(...)
     *   ->withRetryStatus(...)
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
     * @param RetryStatusShape $retryStatus
     */
    public static function with(
        string $mcpServerName,
        string $message,
        ManagedAgentsRetryStatusRetrying|array|ManagedAgentsRetryStatusExhausted|ManagedAgentsRetryStatusTerminal $retryStatus,
    ): self {
        $self = new self;

        $self['mcpServerName'] = $mcpServerName;
        $self['message'] = $message;
        $self['retryStatus'] = $retryStatus;

        return $self;
    }

    /**
     * Name of the MCP server that failed to connect.
     */
    public function withMCPServerName(string $mcpServerName): self
    {
        $self = clone $this;
        $self['mcpServerName'] = $mcpServerName;

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
     * What the client should do next.
     *
     * @param RetryStatusShape $retryStatus
     */
    public function withRetryStatus(
        ManagedAgentsRetryStatusRetrying|array|ManagedAgentsRetryStatusExhausted|ManagedAgentsRetryStatusTerminal $retryStatus,
    ): self {
        $self = clone $this;
        $self['retryStatus'] = $retryStatus;

        return $self;
    }

    /**
     * @param 'mcp_connection_failed_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}

class_alias(
    ManagedAgentsMCPConnectionFailedErrorObject::class,
    'Anthropic\Beta\Sessions\Events\ManagedAgentsMCPConnectionFailedError',
);
