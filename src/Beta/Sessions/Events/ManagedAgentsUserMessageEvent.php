<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEvent\Content;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A user message event in the session conversation.
 *
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEvent\Content
 * @phpstan-import-type ContentVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEvent\Content
 *
 * @phpstan-type ManagedAgentsUserMessageEventShape = array{
 *   id: string,
 *   content: list<ContentShape>,
 *   type: 'user.message',
 *   processedAt?: \DateTimeInterface|null,
 * }
 */
final class ManagedAgentsUserMessageEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsUserMessageEventShape> */
    use SdkModel;

    /** @var 'user.message' $type */
    #[Required(type: new ConstantOf('user.message'))]
    public string $type = 'user.message';

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * Array of content blocks comprising the user message.
     *
     * @var list<ContentVariants> $content
     */
    #[Required(list: Content::class)]
    public array $content;

    /**
     * Timestamp when the agent finished processing this message.
     */
    #[Optional('processed_at', nullable: true)]
    public ?\DateTimeInterface $processedAt;

    /**
     * `new ManagedAgentsUserMessageEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsUserMessageEvent::with(id: ..., content: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsUserMessageEvent())->withID(...)->withContent(...)
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
     */
    public static function with(
        string $id,
        array $content,
        ?\DateTimeInterface $processedAt = null
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['content'] = $content;

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
     * Array of content blocks comprising the user message.
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
     * @param 'user.message' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Timestamp when the agent finished processing this message.
     */
    public function withProcessedAt(?\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }
}
