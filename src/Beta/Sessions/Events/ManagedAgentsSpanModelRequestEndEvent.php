<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsSpanModelRequestEndEvent\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Emitted when a model request completes.
 *
 * @phpstan-import-type ManagedAgentsSpanModelUsageShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSpanModelUsage
 *
 * @phpstan-type ManagedAgentsSpanModelRequestEndEventShape = array{
 *   id: string,
 *   isError: bool|null,
 *   modelRequestStartID: string,
 *   modelUsage: ManagedAgentsSpanModelUsage|ManagedAgentsSpanModelUsageShape,
 *   processedAt: \DateTimeInterface,
 *   type: Type|value-of<Type>,
 * }
 */
final class ManagedAgentsSpanModelRequestEndEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSpanModelRequestEndEventShape> */
    use SdkModel;

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * Whether the model request resulted in an error.
     */
    #[Required('is_error')]
    public ?bool $isError;

    /**
     * The id of the corresponding `span.model_request_start` event.
     */
    #[Required('model_request_start_id')]
    public string $modelRequestStartID;

    /**
     * Token usage for a single model request.
     */
    #[Required('model_usage')]
    public ManagedAgentsSpanModelUsage $modelUsage;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsSpanModelRequestEndEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsSpanModelRequestEndEvent::with(
     *   id: ...,
     *   isError: ...,
     *   modelRequestStartID: ...,
     *   modelUsage: ...,
     *   processedAt: ...,
     *   type: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsSpanModelRequestEndEvent)
     *   ->withID(...)
     *   ->withIsError(...)
     *   ->withModelRequestStartID(...)
     *   ->withModelUsage(...)
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
     * @param ManagedAgentsSpanModelUsage|ManagedAgentsSpanModelUsageShape $modelUsage
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $id,
        ?bool $isError,
        string $modelRequestStartID,
        ManagedAgentsSpanModelUsage|array $modelUsage,
        \DateTimeInterface $processedAt,
        Type|string $type,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['isError'] = $isError;
        $self['modelRequestStartID'] = $modelRequestStartID;
        $self['modelUsage'] = $modelUsage;
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
     * Whether the model request resulted in an error.
     */
    public function withIsError(?bool $isError): self
    {
        $self = clone $this;
        $self['isError'] = $isError;

        return $self;
    }

    /**
     * The id of the corresponding `span.model_request_start` event.
     */
    public function withModelRequestStartID(string $modelRequestStartID): self
    {
        $self = clone $this;
        $self['modelRequestStartID'] = $modelRequestStartID;

        return $self;
    }

    /**
     * Token usage for a single model request.
     *
     * @param ManagedAgentsSpanModelUsage|ManagedAgentsSpanModelUsageShape $modelUsage
     */
    public function withModelUsage(
        ManagedAgentsSpanModelUsage|array $modelUsage
    ): self {
        $self = clone $this;
        $self['modelUsage'] = $modelUsage;

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
