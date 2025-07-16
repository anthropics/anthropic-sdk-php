<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaRawMessageDeltaEvent\Delta;
use Anthropic\Models\Beta\BetaRawMessageDeltaEvent\Type;

final class BetaRawMessageDeltaEvent implements BaseModel
{
    use Model;

    #[Api]
    public Delta $delta;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'message_delta';

    #[Api]
    public BetaMessageDeltaUsage $usage;

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        Delta $delta,
        BetaMessageDeltaUsage $usage,
        string $type = 'message_delta'
    ) {
        $this->delta = $delta;
        $this->type = $type;
        $this->usage = $usage;
    }
}

BetaRawMessageDeltaEvent::_loadMetadata();
