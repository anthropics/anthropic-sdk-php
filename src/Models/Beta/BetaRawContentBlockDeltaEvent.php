<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaRawContentBlockDeltaEvent\Type;

final class BetaRawContentBlockDeltaEvent implements BaseModel
{
    use Model;

    #[Api]
    public BetaCitationsDelta|BetaInputJSONDelta|BetaSignatureDelta|BetaTextDelta|BetaThinkingDelta $delta;

    #[Api]
    public int $index;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'content_block_delta';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        BetaCitationsDelta|BetaInputJSONDelta|BetaSignatureDelta|BetaTextDelta|BetaThinkingDelta $delta,
        int $index,
        string $type = 'content_block_delta',
    ) {
        $this->delta = $delta;
        $this->index = $index;
        $this->type = $type;
    }
}

BetaRawContentBlockDeltaEvent::_loadMetadata();
