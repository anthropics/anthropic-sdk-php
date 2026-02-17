<?php

declare(strict_types=1);

namespace Anthropic\Messages\RawMessageDeltaEvent;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Container;
use Anthropic\Messages\StopReason;

/**
 * @phpstan-import-type ContainerShape from \Anthropic\Messages\Container
 *
 * @phpstan-type DeltaShape = array{
 *   container: null|Container|ContainerShape,
 *   stopReason: null|StopReason|value-of<StopReason>,
 *   stopSequence: string|null,
 * }
 */
final class Delta implements BaseModel
{
    /** @use SdkModel<DeltaShape> */
    use SdkModel;

    /**
     * Information about the container used in the request (for the code execution tool).
     */
    #[Required]
    public ?Container $container;

    /** @var value-of<StopReason>|null $stopReason */
    #[Required('stop_reason', enum: StopReason::class)]
    public ?string $stopReason;

    #[Required('stop_sequence')]
    public ?string $stopSequence;

    /**
     * `new Delta()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Delta::with(container: ..., stopReason: ..., stopSequence: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Delta)->withContainer(...)->withStopReason(...)->withStopSequence(...)
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
     * @param Container|ContainerShape|null $container
     * @param StopReason|value-of<StopReason>|null $stopReason
     */
    public static function with(
        Container|array|null $container,
        StopReason|string|null $stopReason,
        ?string $stopSequence,
    ): self {
        $self = new self;

        $self['container'] = $container;
        $self['stopReason'] = $stopReason;
        $self['stopSequence'] = $stopSequence;

        return $self;
    }

    /**
     * Information about the container used in the request (for the code execution tool).
     *
     * @param Container|ContainerShape|null $container
     */
    public function withContainer(Container|array|null $container): self
    {
        $self = clone $this;
        $self['container'] = $container;

        return $self;
    }

    /**
     * @param StopReason|value-of<StopReason>|null $stopReason
     */
    public function withStopReason(StopReason|string|null $stopReason): self
    {
        $self = clone $this;
        $self['stopReason'] = $stopReason;

        return $self;
    }

    public function withStopSequence(?string $stopSequence): self
    {
        $self = clone $this;
        $self['stopSequence'] = $stopSequence;

        return $self;
    }
}
