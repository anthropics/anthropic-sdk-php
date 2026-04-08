<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMCPToolUseEvent\EvaluatedPermission;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMCPToolUseEvent\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Event emitted when the agent invokes a tool provided by an MCP server.
 *
 * @phpstan-type ManagedAgentsAgentMCPToolUseEventShape = array{
 *   id: string,
 *   input: array<string,mixed>,
 *   mcpServerName: string,
 *   name: string,
 *   processedAt: \DateTimeInterface,
 *   type: Type|value-of<Type>,
 *   evaluatedPermission?: null|EvaluatedPermission|value-of<EvaluatedPermission>,
 * }
 */
final class ManagedAgentsAgentMCPToolUseEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsAgentMCPToolUseEventShape> */
    use SdkModel;

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * Input parameters for the tool call.
     *
     * @var array<string,mixed> $input
     */
    #[Required(map: 'mixed')]
    public array $input;

    /**
     * Name of the MCP server providing the tool.
     */
    #[Required('mcp_server_name')]
    public string $mcpServerName;

    /**
     * Name of the MCP tool being used.
     */
    #[Required]
    public string $name;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * AgentEvaluatedPermission enum.
     *
     * @var value-of<EvaluatedPermission>|null $evaluatedPermission
     */
    #[Optional('evaluated_permission', enum: EvaluatedPermission::class)]
    public ?string $evaluatedPermission;

    /**
     * `new ManagedAgentsAgentMCPToolUseEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsAgentMCPToolUseEvent::with(
     *   id: ...,
     *   input: ...,
     *   mcpServerName: ...,
     *   name: ...,
     *   processedAt: ...,
     *   type: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsAgentMCPToolUseEvent)
     *   ->withID(...)
     *   ->withInput(...)
     *   ->withMCPServerName(...)
     *   ->withName(...)
     *   ->withProcessedAt(...)
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
     * @param array<string,mixed> $input
     * @param Type|value-of<Type> $type
     * @param EvaluatedPermission|value-of<EvaluatedPermission>|null $evaluatedPermission
     */
    public static function with(
        string $id,
        array $input,
        string $mcpServerName,
        string $name,
        \DateTimeInterface $processedAt,
        Type|string $type,
        EvaluatedPermission|string|null $evaluatedPermission = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['input'] = $input;
        $self['mcpServerName'] = $mcpServerName;
        $self['name'] = $name;
        $self['processedAt'] = $processedAt;
        $self['type'] = $type;

        null !== $evaluatedPermission && $self['evaluatedPermission'] = $evaluatedPermission;

        return $self;
    }

    /**
     * Unique identifier for this event.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Input parameters for the tool call.
     *
     * @param array<string,mixed> $input
     */
    public function withInput(array $input): self
    {
        $self = clone $this;
        $self['input'] = $input;

        return $self;
    }

    /**
     * Name of the MCP server providing the tool.
     */
    public function withMCPServerName(string $mcpServerName): self
    {
        $self = clone $this;
        $self['mcpServerName'] = $mcpServerName;

        return $self;
    }

    /**
     * Name of the MCP tool being used.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withProcessedAt(\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

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

    /**
     * AgentEvaluatedPermission enum.
     *
     * @param EvaluatedPermission|value-of<EvaluatedPermission> $evaluatedPermission
     */
    public function withEvaluatedPermission(
        EvaluatedPermission|string $evaluatedPermission
    ): self {
        $self = clone $this;
        $self['evaluatedPermission'] = $evaluatedPermission;

        return $self;
    }
}
