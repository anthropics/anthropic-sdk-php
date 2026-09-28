<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMCPToolUseEvent\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Event emitted when the agent invokes a tool provided by an MCP server.
 *
 * @phpstan-import-type ManagedAgentsAgentToolEvaluationVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolEvaluation
 * @phpstan-import-type ManagedAgentsAgentToolEvaluationShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolEvaluation
 *
 * @phpstan-type ManagedAgentsAgentMCPToolUseEventShape = array{
 *   id: string,
 *   input: array<string,mixed>,
 *   mcpServerName: string,
 *   name: string,
 *   processedAt: \DateTimeInterface,
 *   type: Type|value-of<Type>,
 *   evaluatedPermission?: null|ManagedAgentsAgentEvaluatedPermission|value-of<ManagedAgentsAgentEvaluatedPermission>,
 *   evaluation?: ManagedAgentsAgentToolEvaluationShape|null,
 *   sessionThreadID?: string|null,
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
     * Timestamp when this event was processed.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * The evaluated permission policy for this tool invocation.
     *
     * @var value-of<ManagedAgentsAgentEvaluatedPermission>|null $evaluatedPermission
     */
    #[Optional(
        'evaluated_permission',
        enum: ManagedAgentsAgentEvaluatedPermission::class
    )]
    public ?string $evaluatedPermission;

    /**
     * Which resolved permission_policy produced evaluated_permission: always_allow, always_ask, or auto (with the server's per-invocation judgement). Absent only when the server refused the call before any policy applied (for example, the named tool is not enabled in the session); such a refusal has evaluated_permission deny. An event recorded before this field existed reads as the arm its evaluated_permission implies (always_allow for allow, always_ask for ask).
     *
     * @var ManagedAgentsAgentToolEvaluationVariants|null $evaluation
     */
    #[Optional(union: ManagedAgentsAgentToolEvaluation::class)]
    public ManagedAgentsAgentToolEvaluationAlwaysAllow|ManagedAgentsAgentToolEvaluationAlwaysAsk|ManagedAgentsAgentToolEvaluationAuto|null $evaluation;

    /**
     * When set, this event was cross-posted from a subagent's thread to surface its permission request on the primary thread's stream. Empty on the thread's own events. Informational only: the server routes the matching `user.tool_confirmation` by `tool_use_id`, so clients do not send it back.
     */
    #[Optional('session_thread_id', nullable: true)]
    public ?string $sessionThreadID;

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
     * @param ManagedAgentsAgentEvaluatedPermission|value-of<ManagedAgentsAgentEvaluatedPermission>|null $evaluatedPermission
     * @param ManagedAgentsAgentToolEvaluationShape|null $evaluation
     */
    public static function with(
        string $id,
        array $input,
        string $mcpServerName,
        string $name,
        \DateTimeInterface $processedAt,
        Type|string $type,
        ManagedAgentsAgentEvaluatedPermission|string|null $evaluatedPermission = null,
        ManagedAgentsAgentToolEvaluationAlwaysAllow|array|ManagedAgentsAgentToolEvaluationAlwaysAsk|ManagedAgentsAgentToolEvaluationAuto|null $evaluation = null,
        ?string $sessionThreadID = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['input'] = $input;
        $self['mcpServerName'] = $mcpServerName;
        $self['name'] = $name;
        $self['processedAt'] = $processedAt;
        $self['type'] = $type;

        null !== $evaluatedPermission && $self['evaluatedPermission'] = $evaluatedPermission;
        null !== $evaluation && $self['evaluation'] = $evaluation;
        null !== $sessionThreadID && $self['sessionThreadID'] = $sessionThreadID;

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
     * Timestamp when this event was processed.
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
     * The evaluated permission policy for this tool invocation.
     *
     * @param ManagedAgentsAgentEvaluatedPermission|value-of<ManagedAgentsAgentEvaluatedPermission> $evaluatedPermission
     */
    public function withEvaluatedPermission(
        ManagedAgentsAgentEvaluatedPermission|string $evaluatedPermission
    ): self {
        $self = clone $this;
        $self['evaluatedPermission'] = $evaluatedPermission;

        return $self;
    }

    /**
     * Which resolved permission_policy produced evaluated_permission: always_allow, always_ask, or auto (with the server's per-invocation judgement). Absent only when the server refused the call before any policy applied (for example, the named tool is not enabled in the session); such a refusal has evaluated_permission deny. An event recorded before this field existed reads as the arm its evaluated_permission implies (always_allow for allow, always_ask for ask).
     *
     * @param ManagedAgentsAgentToolEvaluationShape $evaluation
     */
    public function withEvaluation(
        ManagedAgentsAgentToolEvaluationAlwaysAllow|array|ManagedAgentsAgentToolEvaluationAlwaysAsk|ManagedAgentsAgentToolEvaluationAuto $evaluation,
    ): self {
        $self = clone $this;
        $self['evaluation'] = $evaluation;

        return $self;
    }

    /**
     * When set, this event was cross-posted from a subagent's thread to surface its permission request on the primary thread's stream. Empty on the thread's own events. Informational only: the server routes the matching `user.tool_confirmation` by `tool_use_id`, so clients do not send it back.
     */
    public function withSessionThreadID(?string $sessionThreadID): self
    {
        $self = clone $this;
        $self['sessionThreadID'] = $sessionThreadID;

        return $self;
    }
}
