<?php

declare(strict_types=1);

namespace Anthropic\Messages\RawMessageDeltaEvent;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\StopReason;

/**
 * @phpstan-type DeltaShape = array{
 *   stop_reason: value-of<StopReason>|null, stop_sequence: string|null
 * }
 */
final class Delta implements BaseModel
{
    /** @use SdkModel<DeltaShape> */
    use SdkModel;

    /** @var value-of<StopReason>|null $stop_reason */
    #[Api(enum: StopReason::class)]
    public ?string $stop_reason;

    #[Api]
    public ?string $stop_sequence;

    /**
     * `new Delta()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Delta::with(stop_reason: ..., stop_sequence: ...)
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
     * @param StopReason|value-of<StopReason>|null $stop_reason
     */
    public static function with(
        StopReason|string|null $stop_reason,
        ?string $stop_sequence
    ): self {
        $obj = new self;

        $obj['stop_reason'] = $stop_reason;
        $obj['stop_sequence'] = $stop_sequence;

        return $obj;
    }

    /**
     * @param StopReason|value-of<StopReason>|null $stopReason
     */
    public function withStopReason(StopReason|string|null $stopReason): self
    {
        $obj = clone $this;
        $obj['stop_reason'] = $stopReason;

        return $obj;
    }

    public function withStopSequence(?string $stopSequence): self
    {
        $obj = clone $this;
        $obj['stop_sequence'] = $stopSequence;

        return $obj;
    }
}
