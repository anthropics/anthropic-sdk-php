<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\RawMessageDeltaEvent\Delta;

final class RawMessageDeltaEvent implements BaseModel
{
    use Model;

    #[Api]
    public Delta $delta;

    #[Api]
    public string $type = 'message_delta';

    #[Api]
    public MessageDeltaUsage $usage;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        Delta $delta,
        MessageDeltaUsage $usage,
        string $type = 'message_delta'
    ) {
        $this->delta = $delta;
        $this->type = $type;
        $this->usage = $usage;
    }
}

RawMessageDeltaEvent::_loadMetadata();
