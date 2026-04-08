<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolConfirmationEvent\Result;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolConfirmationEvent\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A tool confirmation event that approves or denies a pending tool execution.
 *
 * @phpstan-type ManagedAgentsUserToolConfirmationEventShape = array{
 *   id: string,
 *   result: Result|value-of<Result>,
 *   toolUseID: string,
 *   type: Type|value-of<Type>,
 *   denyMessage?: string|null,
 *   processedAt?: \DateTimeInterface|null,
 * }
 */
final class ManagedAgentsUserToolConfirmationEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsUserToolConfirmationEventShape> */
    use SdkModel;

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * UserToolConfirmationResult enum.
     *
     * @var value-of<Result> $result
     */
    #[Required(enum: Result::class)]
    public string $result;

    /**
     * The id of the `agent.tool_use` or `agent.mcp_tool_use` event this result corresponds to, which can be found in the last `session.status_idle` [event's](https://platform.claude.com/docs/en/api/beta/sessions/events/list#beta_managed_agents_session_requires_action.event_ids) `stop_reason.event_ids` field.
     */
    #[Required('tool_use_id')]
    public string $toolUseID;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Optional message providing context for a 'deny' decision. Only allowed when result is 'deny'.
     */
    #[Optional('deny_message', nullable: true)]
    public ?string $denyMessage;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Optional('processed_at', nullable: true)]
    public ?\DateTimeInterface $processedAt;

    /**
     * `new ManagedAgentsUserToolConfirmationEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsUserToolConfirmationEvent::with(
     *   id: ..., result: ..., toolUseID: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsUserToolConfirmationEvent)
     *   ->withID(...)
     *   ->withResult(...)
     *   ->withToolUseID(...)
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
     * @param Result|value-of<Result> $result
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $id,
        Result|string $result,
        string $toolUseID,
        Type|string $type,
        ?string $denyMessage = null,
        ?\DateTimeInterface $processedAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['result'] = $result;
        $self['toolUseID'] = $toolUseID;
        $self['type'] = $type;

        null !== $denyMessage && $self['denyMessage'] = $denyMessage;
        null !== $processedAt && $self['processedAt'] = $processedAt;

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
     * UserToolConfirmationResult enum.
     *
     * @param Result|value-of<Result> $result
     */
    public function withResult(Result|string $result): self
    {
        $self = clone $this;
        $self['result'] = $result;

        return $self;
    }

    /**
     * The id of the `agent.tool_use` or `agent.mcp_tool_use` event this result corresponds to, which can be found in the last `session.status_idle` [event's](https://platform.claude.com/docs/en/api/beta/sessions/events/list#beta_managed_agents_session_requires_action.event_ids) `stop_reason.event_ids` field.
     */
    public function withToolUseID(string $toolUseID): self
    {
        $self = clone $this;
        $self['toolUseID'] = $toolUseID;

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
     * Optional message providing context for a 'deny' decision. Only allowed when result is 'deny'.
     */
    public function withDenyMessage(?string $denyMessage): self
    {
        $self = clone $this;
        $self['denyMessage'] = $denyMessage;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withProcessedAt(?\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }
}
