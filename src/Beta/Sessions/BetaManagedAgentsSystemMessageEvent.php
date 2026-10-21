<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A mid-conversation system message event. Carries system-role content that is appended to the session as a `role: "system"` turn.
 *
 * @phpstan-import-type BetaManagedAgentsSystemContentBlockShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSystemContentBlock
 *
 * @phpstan-type BetaManagedAgentsSystemMessageEventShape = array{
 *   id: string,
 *   content: list<BetaManagedAgentsSystemContentBlock|BetaManagedAgentsSystemContentBlockShape>,
 *   type: 'system.message',
 *   processedAt?: \DateTimeInterface|null,
 * }
 */
final class BetaManagedAgentsSystemMessageEvent implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSystemMessageEventShape> */
    use SdkModel;

    /** @var 'system.message' $type */
    #[Required(type: new ConstantOf('system.message'))]
    public string $type = 'system.message';

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

    /**
     * Timestamp when this system message was processed.
     */
    #[Optional('processed_at', nullable: true)]
    public ?\DateTimeInterface $processedAt;

    /**
     * `new BetaManagedAgentsSystemMessageEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsSystemMessageEvent::with(id: ..., content: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsSystemMessageEvent())->withID(...)->withContent(...)
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
     * @param 'system.message' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Timestamp when this system message was processed.
     */
    public function withProcessedAt(?\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }
}
