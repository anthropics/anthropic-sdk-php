<?php

declare(strict_types=1);

namespace Anthropic\Messages\RawMessageDeltaEvent;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\StopReason;

/**
 * @phpstan-type DeltaShape = array{
 *   stopReason: value-of<StopReason>|null, stopSequence: string|null
 * }
 */
final class Delta implements BaseModel
{
    /** @use SdkModel<DeltaShape> */
    use SdkModel;

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
     * Delta::with(stopReason: ..., stopSequence: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Delta)->withStopReason(...)->withStopSequence(...)
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
     * @param StopReason|value-of<StopReason>|null $stopReason
     */
    public static function with(
        StopReason|string|null $stopReason,
        ?string $stopSequence
    ): self {
        $obj = new self;

        $obj['stopReason'] = $stopReason;
        $obj['stopSequence'] = $stopSequence;

        return $obj;
    }

    /**
     * @param StopReason|value-of<StopReason>|null $stopReason
     */
    public function withStopReason(StopReason|string|null $stopReason): self
    {
        $obj = clone $this;
        $obj['stopReason'] = $stopReason;

        return $obj;
    }

    public function withStopSequence(?string $stopSequence): self
    {
        $obj = clone $this;
        $obj['stopSequence'] = $stopSequence;

        return $obj;
    }
}
