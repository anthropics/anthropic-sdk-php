<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsMCPConnectionFailedError\RetryStatus;
use Anthropic\Beta\Sessions\Events\ManagedAgentsMCPConnectionFailedError\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Failed to connect to an MCP server.
 *
 * @phpstan-import-type RetryStatusVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsMCPConnectionFailedError\RetryStatus
 * @phpstan-import-type RetryStatusShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsMCPConnectionFailedError\RetryStatus
 *
 * @phpstan-type ManagedAgentsMCPConnectionFailedErrorShape = array{
 *   mcpServerName: string,
 *   message: string,
 *   retryStatus: RetryStatusShape,
 *   type: Type|value-of<Type>,
 * }
 */
final class ManagedAgentsMCPConnectionFailedError implements BaseModel
{
    /** @use SdkModel<ManagedAgentsMCPConnectionFailedErrorShape> */
    use SdkModel;

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
     * What the client should do next in response to this error.
     *
     * @var RetryStatusVariants $retryStatus
     */
    #[Required('retry_status', union: RetryStatus::class)]
    public ManagedAgentsRetryStatusRetrying|ManagedAgentsRetryStatusExhausted|ManagedAgentsRetryStatusTerminal $retryStatus;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsMCPConnectionFailedError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsMCPConnectionFailedError::with(
     *   mcpServerName: ..., message: ..., retryStatus: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsMCPConnectionFailedError)
     *   ->withMCPServerName(...)
     *   ->withMessage(...)
     *   ->withRetryStatus(...)
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
     * @param RetryStatusShape $retryStatus
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $mcpServerName,
        string $message,
        ManagedAgentsRetryStatusRetrying|array|ManagedAgentsRetryStatusExhausted|ManagedAgentsRetryStatusTerminal $retryStatus,
        Type|string $type,
    ): self {
        $self = new self;

        $self['mcpServerName'] = $mcpServerName;
        $self['message'] = $message;
        $self['retryStatus'] = $retryStatus;
        $self['type'] = $type;

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
     * What the client should do next in response to this error.
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
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
