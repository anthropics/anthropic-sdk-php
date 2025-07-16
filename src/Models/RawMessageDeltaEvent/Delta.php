<?php

declare(strict_types=1);

namespace Anthropic\Models\RawMessageDeltaEvent;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\StopReason;

final class Delta implements BaseModel
{
    use Model;

    /** @var StopReason::* $stopReason */
    #[Api('stop_reason')]
    public string $stopReason;

    #[Api('stop_sequence')]
    public ?string $stopSequence;

    /**
     * You must use named parameters to construct this object.
     *
     * @param StopReason::* $stopReason
     */
    final public function __construct(string $stopReason, ?string $stopSequence)
    {
        $this->stopReason = $stopReason;
        $this->stopSequence = $stopSequence;
    }
}

Delta::_loadMetadata();
