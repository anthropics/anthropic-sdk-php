<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadMessageSentEvent\Content;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadMessageSentEvent\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Observability event emitted to the sender's output stream when an agent-to-agent message is sent.
 *
 * @phpstan-import-type ContentVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadMessageSentEvent\Content
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadMessageSentEvent\Content
 *
 * @phpstan-type ManagedAgentsAgentThreadMessageSentEventShape = array{
 *   id: string,
 *   content: list<ContentShape>,
 *   processedAt: \DateTimeInterface,
 *   toSessionThreadID: string,
 *   type: Type|value-of<Type>,
 *   toAgentName?: string|null,
 * }
 */
final class ManagedAgentsAgentThreadMessageSentEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsAgentThreadMessageSentEventShape> */
    use SdkModel;

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * Message content blocks.
     *
     * @var list<ContentVariants> $content
     */
    #[Required(list: Content::class)]
    public array $content;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /**
     * Public `sthr_` ID of the thread the message was sent to.
     */
    #[Required('to_session_thread_id')]
    public string $toSessionThreadID;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Name of the callable agent this message was sent to. Absent when sent to the primary agent.
     */
    #[Optional('to_agent_name', nullable: true)]
    public ?string $toAgentName;

    /**
     * `new ManagedAgentsAgentThreadMessageSentEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsAgentThreadMessageSentEvent::with(
     *   id: ..., content: ..., processedAt: ..., toSessionThreadID: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsAgentThreadMessageSentEvent)
     *   ->withID(...)
     *   ->withContent(...)
     *   ->withProcessedAt(...)
     *   ->withToSessionThreadID(...)
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
     * @param list<ContentShape> $content
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $id,
        array $content,
        \DateTimeInterface $processedAt,
        string $toSessionThreadID,
        Type|string $type,
        ?string $toAgentName = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['content'] = $content;
        $self['processedAt'] = $processedAt;
        $self['toSessionThreadID'] = $toSessionThreadID;
        $self['type'] = $type;

        null !== $toAgentName && $self['toAgentName'] = $toAgentName;

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
     * Message content blocks.
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
     * A timestamp in RFC 3339 format.
     */
    public function withProcessedAt(\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }

    /**
     * Public `sthr_` ID of the thread the message was sent to.
     */
    public function withToSessionThreadID(string $toSessionThreadID): self
    {
        $self = clone $this;
        $self['toSessionThreadID'] = $toSessionThreadID;

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
     * Name of the callable agent this message was sent to. Absent when sent to the primary agent.
     */
    public function withToAgentName(?string $toAgentName): self
    {
        $self = clone $this;
        $self['toAgentName'] = $toAgentName;

        return $self;
    }
}
