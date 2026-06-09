<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Sessions\BetaManagedAgentsSystemMessageEvent\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A mid-conversation system message event. Carries system-role content that is appended to the session as a `role: "system"` turn.
 *
 * @phpstan-import-type BetaManagedAgentsSystemContentBlockShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSystemContentBlock
 *
 * @phpstan-type BetaManagedAgentsSystemMessageEventShape = array{
 *   id: string,
 *   content: list<BetaManagedAgentsSystemContentBlock|BetaManagedAgentsSystemContentBlockShape>,
 *   type: Type|value-of<Type>,
 *   processedAt?: \DateTimeInterface|null,
 * }
 */
final class BetaManagedAgentsSystemMessageEvent implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSystemMessageEventShape> */
    use SdkModel;

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * System content blocks. Text-only.
     *
     * @var list<BetaManagedAgentsSystemContentBlock> $content
     */
    #[Required(list: BetaManagedAgentsSystemContentBlock::class)]
    public array $content;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Optional('processed_at', nullable: true)]
    public ?\DateTimeInterface $processedAt;

    /**
     * `new BetaManagedAgentsSystemMessageEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsSystemMessageEvent::with(id: ..., content: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsSystemMessageEvent)
     *   ->withID(...)
     *   ->withContent(...)
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
     * @param list<BetaManagedAgentsSystemContentBlock|BetaManagedAgentsSystemContentBlockShape> $content
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $id,
        array $content,
        Type|string $type,
        ?\DateTimeInterface $processedAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['content'] = $content;
        $self['type'] = $type;

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
     * System content blocks. Text-only.
     *
     * @param list<BetaManagedAgentsSystemContentBlock|BetaManagedAgentsSystemContentBlockShape> $content
     */
    public function withContent(array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

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
     * A timestamp in RFC 3339 format.
     */
    public function withProcessedAt(?\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }
}
