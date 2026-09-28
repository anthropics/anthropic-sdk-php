<?php

declare(strict_types=1);

namespace Anthropic\Messages\RawMessageDeltaEvent;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Container;
use Anthropic\Messages\RefusalStopDetails;
use Anthropic\Messages\StopReason;

/**
 * @phpstan-import-type ContainerShape from \Anthropic\Messages\Container
 * @phpstan-import-type RefusalStopDetailsShape from \Anthropic\Messages\RefusalStopDetails
 *
 * @phpstan-type DeltaShape = array{
 *   container: null|Container|ContainerShape,
 *   stopDetails: null|RefusalStopDetails|RefusalStopDetailsShape,
 *   stopReason: null|StopReason|value-of<StopReason>,
 *   stopSequence: string|null,
 * }
 */
final class Delta implements BaseModel
{
    /** @use SdkModel<DeltaShape> */
    use SdkModel;

    /**
     * Information about the container used in this request.
     *
     * This will be non-null if a container tool (e.g. code execution) was used.
     */
    #[Required]
    public ?Container $container;

    /**
     * Structured information about why model output stopped.
     *
     * This is `null` when the `stop_reason` has no additional detail to report.
     */
    #[Required('stop_details')]
    public ?RefusalStopDetails $stopDetails;

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
     * Delta::with(
     *   container: ..., stopDetails: ..., stopReason: ..., stopSequence: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Delta)
     *   ->withContainer(...)
     *   ->withStopDetails(...)
     *   ->withStopReason(...)
     *   ->withStopSequence(...)
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
     * @param RefusalStopDetails|RefusalStopDetailsShape|null $stopDetails
     * @param StopReason|value-of<StopReason>|null $stopReason
     */
    public static function with(
        Container|array|null $container,
        RefusalStopDetails|array|null $stopDetails,
        StopReason|string|null $stopReason,
        ?string $stopSequence,
    ): self {
        $self = new self;

        $self['container'] = $container;
        $self['stopDetails'] = $stopDetails;
        $self['stopReason'] = $stopReason;
        $self['stopSequence'] = $stopSequence;

        return $self;
    }

    /**
     * Information about the container used in this request.
     *
     * This will be non-null if a container tool (e.g. code execution) was used.
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
     * Structured information about why model output stopped.
     *
     * This is `null` when the `stop_reason` has no additional detail to report.
     *
     * @param RefusalStopDetails|RefusalStopDetailsShape|null $stopDetails
     */
    public function withStopDetails(
        RefusalStopDetails|array|null $stopDetails
    ): self {
        $self = clone $this;
        $self['stopDetails'] = $stopDetails;

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
