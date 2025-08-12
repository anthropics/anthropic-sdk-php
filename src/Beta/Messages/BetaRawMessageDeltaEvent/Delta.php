<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaRawMessageDeltaEvent;

use Anthropic\Beta\Messages\BetaContainer;
use Anthropic\Beta\Messages\BetaStopReason;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
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
    use Model;

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
    public static function new(
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
    public function setContainer(BetaContainer $container): self
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @param BetaStopReason::* $stopReason
     */
    public function setStopReason(string $stopReason): self
    {
        $this->stopReason = $stopReason;

        return $this;
    }

    public function setStopSequence(?string $stopSequence): self
    {
        $this->stopSequence = $stopSequence;

        return $this;
    }
}
