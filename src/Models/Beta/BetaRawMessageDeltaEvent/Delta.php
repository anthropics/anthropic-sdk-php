<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaRawMessageDeltaEvent;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaContainer;
use Anthropic\Models\Beta\BetaStopReason;

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
    #[Api('stop_reason')]
    public string $stopReason;

    #[Api('stop_sequence')]
    public ?string $stopSequence;

    /**
     * You must use named parameters to construct this object.
     *
     * @param BetaStopReason::* $stopReason
     */
    final public function __construct(
        BetaContainer $container,
        string $stopReason,
        ?string $stopSequence
    ) {
        self::introspect();

        $this->container = $container;
        $this->stopReason = $stopReason;
        $this->stopSequence = $stopSequence;
    }
}
