<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaRawMessageDeltaEvent;

use Anthropic\Beta\Messages\BetaContainer;
use Anthropic\Beta\Messages\BetaStopReason;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type delta_alias = array{
 *   container: BetaContainer|null,
 *   stopReason: value-of<BetaStopReason>|null,
 *   stopSequence: string|null,
 * }
 */
final class Delta implements BaseModel
{
    /** @use SdkModel<delta_alias> */
    use SdkModel;

    /**
     * Information about the container used in the request (for the code execution tool).
     */
    #[Api]
    public ?BetaContainer $container;

    /** @var value-of<BetaStopReason>|null $stopReason */
    #[Api('stop_reason', enum: BetaStopReason::class)]
    public ?string $stopReason;

    #[Api('stop_sequence')]
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
     * @param BetaStopReason|value-of<BetaStopReason>|null $stopReason
     */
    public static function with(
        ?BetaContainer $container,
        BetaStopReason|string|null $stopReason,
        ?string $stopSequence,
    ): self {
        $obj = new self;

        $obj->container = $container;
        $obj->stopReason = $stopReason instanceof BetaStopReason ? $stopReason->value : $stopReason;
        $obj->stopSequence = $stopSequence;

        return $obj;
    }

    /**
     * Information about the container used in the request (for the code execution tool).
     */
    public function withContainer(?BetaContainer $container): self
    {
        $obj = clone $this;
        $obj->container = $container;

        return $obj;
    }

    /**
     * @param BetaStopReason|value-of<BetaStopReason>|null $stopReason
     */
    public function withStopReason(BetaStopReason|string|null $stopReason): self
    {
        $obj = clone $this;
        $obj->stopReason = $stopReason instanceof BetaStopReason ? $stopReason->value : $stopReason;

        return $obj;
    }

    public function withStopSequence(?string $stopSequence): self
    {
        $obj = clone $this;
        $obj->stopSequence = $stopSequence;

        return $obj;
    }
}
