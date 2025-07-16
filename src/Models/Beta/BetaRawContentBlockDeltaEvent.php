<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaRawContentBlockDeltaEvent implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'content_block_delta';

    #[Api]
    public BetaCitationsDelta|BetaInputJSONDelta|BetaSignatureDelta|BetaTextDelta|BetaThinkingDelta $delta;

    #[Api]
    public int $index;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        BetaCitationsDelta|BetaInputJSONDelta|BetaSignatureDelta|BetaTextDelta|BetaThinkingDelta $delta,
        int $index,
    ) {
        $this->delta = $delta;
        $this->index = $index;
    }
}

BetaRawContentBlockDeltaEvent::_loadMetadata();
