<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEvent\Content;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEvent\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Event sent by the client providing the result of a custom tool execution.
 *
 * @phpstan-import-type ContentVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEvent\Content
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEvent\Content
 *
 * @phpstan-type ManagedAgentsUserCustomToolResultEventShape = array{
 *   id: string,
 *   customToolUseID: string,
 *   type: Type|value-of<Type>,
 *   content?: list<ContentShape>|null,
 *   isError?: bool|null,
 *   processedAt?: \DateTimeInterface|null,
 * }
 */
final class ManagedAgentsUserCustomToolResultEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsUserCustomToolResultEventShape> */
    use SdkModel;

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * The id of the `agent.custom_tool_use` event this result corresponds to, which can be found in the last `session.status_idle` [event's](https://platform.claude.com/docs/en/api/beta/sessions/events/list#beta_managed_agents_session_requires_action.event_ids) `stop_reason.event_ids` field.
     */
    #[Required('custom_tool_use_id')]
    public string $customToolUseID;

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
     * `new ManagedAgentsUserCustomToolResultEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsUserCustomToolResultEvent::with(
     *   id: ..., customToolUseID: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsUserCustomToolResultEvent)
     *   ->withID(...)
     *   ->withCustomToolUseID(...)
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
        string $customToolUseID,
        Type|string $type,
        ?array $content = null,
        ?bool $isError = null,
        ?\DateTimeInterface $processedAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['customToolUseID'] = $customToolUseID;
        $self['type'] = $type;

        null !== $content && $self['content'] = $content;
        null !== $isError && $self['isError'] = $isError;
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
     * The id of the `agent.custom_tool_use` event this result corresponds to, which can be found in the last `session.status_idle` [event's](https://platform.claude.com/docs/en/api/beta/sessions/events/list#beta_managed_agents_session_requires_action.event_ids) `stop_reason.event_ids` field.
     */
    public function withCustomToolUseID(string $customToolUseID): self
    {
        $self = clone $this;
        $self['customToolUseID'] = $customToolUseID;

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
}
