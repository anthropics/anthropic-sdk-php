<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEvent\Content;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Event sent by the client providing the result of a custom tool execution.
 *
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEvent\Content
 * @phpstan-import-type ContentVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEvent\Content
 *
 * @phpstan-type ManagedAgentsUserCustomToolResultEventShape = array{
 *   id: string,
 *   customToolUseID: string,
 *   type: 'user.custom_tool_result',
 *   content?: list<ContentShape>|null,
 *   isError?: bool|null,
 *   processedAt?: \DateTimeInterface|null,
 *   sessionThreadID?: string|null,
 * }
 */
final class ManagedAgentsUserCustomToolResultEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsUserCustomToolResultEventShape> */
    use SdkModel;

    /** @var 'user.custom_tool_result' $type */
    #[Required(type: new ConstantOf('user.custom_tool_result'))]
    public string $type = 'user.custom_tool_result';

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * The id of the `agent.custom_tool_use` event this result corresponds to. It is also listed in the last `session.status_idle` [event's](https://platform.claude.com/docs/en/api/beta/sessions/events/list#beta_managed_agents_session_requires_action.event_ids) `stop_reason.event_ids` field.
     */
    #[Required('custom_tool_use_id')]
    public string $customToolUseID;

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
     * Timestamp when this result was processed.
     */
    #[Optional('processed_at', nullable: true)]
    public ?\DateTimeInterface $processedAt;

    /**
     * Set by the server to the subagent thread this result was routed to. Omitted when it was routed to the primary thread.
     */
    #[Optional('session_thread_id', nullable: true)]
    public ?string $sessionThreadID;

    /**
     * `new ManagedAgentsUserCustomToolResultEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsUserCustomToolResultEvent::with(id: ..., customToolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsUserCustomToolResultEvent())
     *   ->withID(...)
     *   ->withCustomToolUseID(...)
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
     * @param list<ContentShape>|null $content
     */
    public static function with(
        string $id,
        string $customToolUseID,
        ?array $content = null,
        ?bool $isError = null,
        ?\DateTimeInterface $processedAt = null,
        ?string $sessionThreadID = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['customToolUseID'] = $customToolUseID;

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
     * The id of the `agent.custom_tool_use` event this result corresponds to. It is also listed in the last `session.status_idle` [event's](https://platform.claude.com/docs/en/api/beta/sessions/events/list#beta_managed_agents_session_requires_action.event_ids) `stop_reason.event_ids` field.
     */
    public function withCustomToolUseID(string $customToolUseID): self
    {
        $self = clone $this;
        $self['customToolUseID'] = $customToolUseID;

        return $self;
    }

    /**
     * @param 'user.custom_tool_result' $type
     */
    public function withType(string $type): self
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
     * Timestamp when this result was processed.
     */
    public function withProcessedAt(?\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }

    /**
     * Set by the server to the subagent thread this result was routed to. Omitted when it was routed to the primary thread.
     */
    public function withSessionThreadID(?string $sessionThreadID): self
    {
        $self = clone $this;
        $self['sessionThreadID'] = $sessionThreadID;

        return $self;
    }
}
