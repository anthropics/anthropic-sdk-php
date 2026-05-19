<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Sessions\BetaManagedAgentsSessionUpdatedEvent\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Emitted when an UpdateSession request changed at least one field. Carries only the fields that changed; absent fields were not part of the update. The new configuration applies from the next turn.
 *
 * @phpstan-import-type BetaManagedAgentsSessionAgentShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionAgent
 *
 * @phpstan-type BetaManagedAgentsSessionUpdatedEventShape = array{
 *   id: string,
 *   processedAt: \DateTimeInterface,
 *   type: Type|value-of<Type>,
 *   agent?: null|BetaManagedAgentsSessionAgent|BetaManagedAgentsSessionAgentShape,
 *   metadata?: array<string,string>|null,
 *   title?: string|null,
 * }
 */
final class BetaManagedAgentsSessionUpdatedEvent implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSessionUpdatedEventShape> */
    use SdkModel;

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Resolved `agent` definition for a `session`. Snapshot of the `agent` at `session` creation time.
     */
    #[Optional(nullable: true)]
    public ?BetaManagedAgentsSessionAgent $agent;

    /**
     * The session's full metadata bag after the update. Present when the update set non-empty metadata; absent when metadata was unchanged or cleared to empty.
     *
     * @var array<string,string>|null $metadata
     */
    #[Optional(map: 'string')]
    public ?array $metadata;

    /**
     * The session's new title. Present only when the update changed it.
     */
    #[Optional(nullable: true)]
    public ?string $title;

    /**
     * `new BetaManagedAgentsSessionUpdatedEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsSessionUpdatedEvent::with(id: ..., processedAt: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsSessionUpdatedEvent)
     *   ->withID(...)
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
     * @param Type|value-of<Type> $type
     * @param BetaManagedAgentsSessionAgent|BetaManagedAgentsSessionAgentShape|null $agent
     * @param array<string,string>|null $metadata
     */
    public static function with(
        string $id,
        \DateTimeInterface $processedAt,
        Type|string $type,
        BetaManagedAgentsSessionAgent|array|null $agent = null,
        ?array $metadata = null,
        ?string $title = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['processedAt'] = $processedAt;
        $self['type'] = $type;

        null !== $agent && $self['agent'] = $agent;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $title && $self['title'] = $title;

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
     * Resolved `agent` definition for a `session`. Snapshot of the `agent` at `session` creation time.
     *
     * @param BetaManagedAgentsSessionAgent|BetaManagedAgentsSessionAgentShape|null $agent
     */
    public function withAgent(
        BetaManagedAgentsSessionAgent|array|null $agent
    ): self {
        $self = clone $this;
        $self['agent'] = $agent;

        return $self;
    }

    /**
     * The session's full metadata bag after the update. Present when the update set non-empty metadata; absent when metadata was unchanged or cleared to empty.
     *
     * @param array<string,string> $metadata
     */
    public function withMetadata(array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * The session's new title. Present only when the update changed it.
     */
    public function withTitle(?string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }
}
