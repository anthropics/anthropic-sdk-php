<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Sessions\BetaManagedAgentsUserToolResultEvent\Content;
use Anthropic\Beta\Sessions\BetaManagedAgentsUserToolResultEvent\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Event sent by the client providing the result of an agent-toolset tool execution. Only valid on `self_hosted` environments, where sandbox-routed tools are executed by the client rather than the server.
 *
 * @phpstan-import-type ContentVariants from \Anthropic\Beta\Sessions\BetaManagedAgentsUserToolResultEvent\Content
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\BetaManagedAgentsUserToolResultEvent\Content
 *
 * @phpstan-type BetaManagedAgentsUserToolResultEventShape = array{
 *   id: string,
 *   toolUseID: string,
 *   type: Type|value-of<Type>,
 *   content?: list<ContentShape>|null,
 *   isError?: bool|null,
 *   processedAt?: \DateTimeInterface|null,
 *   sessionThreadID?: string|null,
 * }
 */
final class BetaManagedAgentsUserToolResultEvent implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsUserToolResultEventShape> */
    use SdkModel;

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * The id of the `agent.tool_use` event this result corresponds to, which can be found in the last `session.status_idle` [event's](https://platform.claude.com/docs/en/api/beta/sessions/events/list#beta_managed_agents_session_requires_action.event_ids) `stop_reason.event_ids` field.
     */
    #[Required('tool_use_id')]
    public string $toolUseID;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * The result content returned by the tool.
     *
     * @var list<ContentVariants>|null $content
     */
    #[Optional(list: Content::class)]
    public ?array $content;

    /**
     * Whether the tool execution resulted in an error.
     */
    #[Optional('is_error', nullable: true)]
    public ?bool $isError;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Optional('processed_at', nullable: true)]
    public ?\DateTimeInterface $processedAt;

    /**
     * Routes this result to a subagent thread. Copy from the `agent.tool_use` event's `session_thread_id`.
     */
    #[Optional('session_thread_id', nullable: true)]
    public ?string $sessionThreadID;

    /**
     * `new BetaManagedAgentsUserToolResultEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsUserToolResultEvent::with(id: ..., toolUseID: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsUserToolResultEvent)
     *   ->withID(...)
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
     * @param Type|value-of<Type> $type
     * @param list<ContentShape>|null $content
     */
    public static function with(
        string $id,
        string $toolUseID,
        Type|string $type,
        ?array $content = null,
        ?bool $isError = null,
        ?\DateTimeInterface $processedAt = null,
        ?string $sessionThreadID = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['toolUseID'] = $toolUseID;
        $self['type'] = $type;

        null !== $content && $self['content'] = $content;
        null !== $isError && $self['isError'] = $isError;
        null !== $processedAt && $self['processedAt'] = $processedAt;
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
     * The id of the `agent.tool_use` event this result corresponds to, which can be found in the last `session.status_idle` [event's](https://platform.claude.com/docs/en/api/beta/sessions/events/list#beta_managed_agents_session_requires_action.event_ids) `stop_reason.event_ids` field.
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
     * The result content returned by the tool.
     *
     * @param list<ContentShape> $content
     */
    public function withContent(array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * Whether the tool execution resulted in an error.
     */
    public function withIsError(?bool $isError): self
    {
        $self = clone $this;
        $self['isError'] = $isError;

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

    /**
     * Routes this result to a subagent thread. Copy from the `agent.tool_use` event's `session_thread_id`.
     */
    public function withSessionThreadID(?string $sessionThreadID): self
    {
        $self = clone $this;
        $self['sessionThreadID'] = $sessionThreadID;

        return $self;
    }
}
