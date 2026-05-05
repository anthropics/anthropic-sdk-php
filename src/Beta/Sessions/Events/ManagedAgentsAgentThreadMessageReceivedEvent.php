<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadMessageReceivedEvent\Content;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadMessageReceivedEvent\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Delivery event written to the target thread's input stream when an agent-to-agent message arrives.
 *
 * @phpstan-import-type ContentVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadMessageReceivedEvent\Content
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadMessageReceivedEvent\Content
 *
 * @phpstan-type ManagedAgentsAgentThreadMessageReceivedEventShape = array{
 *   id: string,
 *   content: list<ContentShape>,
 *   fromSessionThreadID: string,
 *   processedAt: \DateTimeInterface,
 *   type: Type|value-of<Type>,
 *   fromAgentName?: string|null,
 * }
 */
final class ManagedAgentsAgentThreadMessageReceivedEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsAgentThreadMessageReceivedEventShape> */
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
     * Public `sthr_` ID of the thread that sent the message.
     */
    #[Required('from_session_thread_id')]
    public string $fromSessionThreadID;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Name of the callable agent this message came from. Absent when received from the primary agent.
     */
    #[Optional('from_agent_name', nullable: true)]
    public ?string $fromAgentName;

    /**
     * `new ManagedAgentsAgentThreadMessageReceivedEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsAgentThreadMessageReceivedEvent::with(
     *   id: ..., content: ..., fromSessionThreadID: ..., processedAt: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsAgentThreadMessageReceivedEvent)
     *   ->withID(...)
     *   ->withContent(...)
     *   ->withFromSessionThreadID(...)
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
     * @param list<ContentShape> $content
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $id,
        array $content,
        string $fromSessionThreadID,
        \DateTimeInterface $processedAt,
        Type|string $type,
        ?string $fromAgentName = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['content'] = $content;
        $self['fromSessionThreadID'] = $fromSessionThreadID;
        $self['processedAt'] = $processedAt;
        $self['type'] = $type;

        null !== $fromAgentName && $self['fromAgentName'] = $fromAgentName;

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
     * Public `sthr_` ID of the thread that sent the message.
     */
    public function withFromSessionThreadID(string $fromSessionThreadID): self
    {
        $self = clone $this;
        $self['fromSessionThreadID'] = $fromSessionThreadID;

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
     * Name of the callable agent this message came from. Absent when received from the primary agent.
     */
    public function withFromAgentName(?string $fromAgentName): self
    {
        $self = clone $this;
        $self['fromAgentName'] = $fromAgentName;

        return $self;
    }
}
