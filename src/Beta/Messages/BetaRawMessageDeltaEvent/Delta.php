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
 *   container: BetaContainer,
 *   stopReason: BetaStopReason::*,
 *   stopSequence: string|null,
 * }
 */
final class Delta implements BaseModel
{
    use SdkModel;

    /**
     * Information about the container used in the request (for the code execution tool).
     */
    #[Api]
    public BetaContainer $container;

    /** @var BetaStopReason::* $stopReason */
    #[Api('stop_reason', enum: BetaStopReason::class)]
    public string $stopReason;

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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaStopReason::* $stopReason
     */
    public static function with(
        BetaContainer $container,
        string $stopReason,
        ?string $stopSequence
    ): self {
        $obj = new self;

        $obj->container = $container;
        $obj->stopReason = $stopReason;
        $obj->stopSequence = $stopSequence;

        return $obj;
    }

    /**
     * Information about the container used in the request (for the code execution tool).
     */
    public function withContainer(BetaContainer $container): self
    {
        $obj = clone $this;
        $obj->container = $container;

        return $obj;
    }

    /**
     * @param BetaStopReason::* $stopReason
     */
    public function withStopReason(string $stopReason): self
    {
        $obj = clone $this;
        $obj->stopReason = $stopReason;

        return $obj;
    }

    public function withStopSequence(?string $stopSequence): self
    {
        $obj = clone $this;
        $obj->stopSequence = $stopSequence;

        return $obj;
    }
}
