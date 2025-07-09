<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaRawContentBlockDeltaEvent implements BaseModel
{
    use Model;

    /**
     * @var BetaCitationsDelta|BetaInputJSONDelta|BetaSignatureDelta|BetaTextDelta|BetaThinkingDelta $delta
     */
    #[Api]
    public mixed $delta;

    #[Api]
    public int $index;

    #[Api]
    public string $type;

    /**
     * @param BetaCitationsDelta|BetaInputJSONDelta|BetaSignatureDelta|BetaTextDelta|BetaThinkingDelta $delta
     * @param int                                                                                      $index
     * @param string                                                                                   $type
     */
    final public function __construct($delta, $index, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaRawContentBlockDeltaEvent::_loadMetadata();
