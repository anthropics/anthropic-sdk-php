<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaRawMessageDeltaEvent;

use Anthropic\Beta\Messages\BetaContainer;
use Anthropic\Beta\Messages\BetaSkill;
use Anthropic\Beta\Messages\BetaStopReason;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type DeltaShape = array{
 *   container: BetaContainer|null,
 *   stop_reason: value-of<BetaStopReason>|null,
 *   stop_sequence: string|null,
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
    public ?BetaContainer $container;

    /** @var value-of<BetaStopReason>|null $stop_reason */
    #[Required(enum: BetaStopReason::class)]
    public ?string $stop_reason;

    #[Required]
    public ?string $stop_sequence;

    /**
     * `new Delta()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Delta::with(container: ..., stop_reason: ..., stop_sequence: ...)
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
     * @param BetaContainer|array{
     *   id: string, expires_at: \DateTimeInterface, skills: list<BetaSkill>|null
     * }|null $container
     * @param BetaStopReason|value-of<BetaStopReason>|null $stop_reason
     */
    public static function with(
        BetaContainer|array|null $container,
        BetaStopReason|string|null $stop_reason,
        ?string $stop_sequence,
    ): self {
        $obj = new self;

        $obj['container'] = $container;
        $obj['stop_reason'] = $stop_reason;
        $obj['stop_sequence'] = $stop_sequence;

        return $obj;
    }

    /**
     * Information about the container used in the request (for the code execution tool).
     *
     * @param BetaContainer|array{
     *   id: string, expires_at: \DateTimeInterface, skills: list<BetaSkill>|null
     * }|null $container
     */
    public function withContainer(BetaContainer|array|null $container): self
    {
        $obj = clone $this;
        $obj['container'] = $container;

        return $obj;
    }

    /**
     * @param BetaStopReason|value-of<BetaStopReason>|null $stopReason
     */
    public function withStopReason(BetaStopReason|string|null $stopReason): self
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
