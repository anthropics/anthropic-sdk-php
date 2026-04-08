<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMessageEvent\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * An agent response event in the session conversation.
 *
 * @phpstan-import-type ManagedAgentsTextBlockShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsTextBlock
 *
 * @phpstan-type ManagedAgentsAgentMessageEventShape = array{
 *   id: string,
 *   content: list<ManagedAgentsTextBlock|ManagedAgentsTextBlockShape>,
 *   processedAt: \DateTimeInterface,
 *   type: Type|value-of<Type>,
 * }
 */
final class ManagedAgentsAgentMessageEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsAgentMessageEventShape> */
    use SdkModel;

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * Array of text blocks comprising the agent response.
     *
     * @var list<ManagedAgentsTextBlock> $content
     */
    #[Required(list: ManagedAgentsTextBlock::class)]
    public array $content;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsAgentMessageEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsAgentMessageEvent::with(
     *   id: ..., content: ..., processedAt: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsAgentMessageEvent)
     *   ->withID(...)
     *   ->withContent(...)
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
     * @param list<ManagedAgentsTextBlock|ManagedAgentsTextBlockShape> $content
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $id,
        array $content,
        \DateTimeInterface $processedAt,
        Type|string $type,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['content'] = $content;
        $self['processedAt'] = $processedAt;
        $self['type'] = $type;

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
     * Array of text blocks comprising the agent response.
     *
     * @param list<ManagedAgentsTextBlock|ManagedAgentsTextBlockShape> $content
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
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
