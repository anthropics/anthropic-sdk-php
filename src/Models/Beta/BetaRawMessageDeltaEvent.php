<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaRawMessageDeltaEvent\Delta;

final class BetaRawMessageDeltaEvent implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'message_delta';

    #[Api]
    public Delta $delta;

    #[Api]
    public BetaMessageDeltaUsage $usage;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(Delta $delta, BetaMessageDeltaUsage $usage)
    {
        $this->delta = $delta;
        $this->usage = $usage;
    }
}

BetaRawMessageDeltaEvent::__introspect();
