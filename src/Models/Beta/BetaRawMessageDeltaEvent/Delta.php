<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaRawMessageDeltaEvent;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaContainer;
use Anthropic\Models\Beta\BetaStopReason;

final class Delta implements BaseModel
{
    use Model;

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
        $this->container = $container;
        $this->stopReason = $stopReason;
        $this->stopSequence = $stopSequence;
    }
}

Delta::_loadMetadata();
