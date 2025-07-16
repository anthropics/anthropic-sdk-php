<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\RawContentBlockDeltaEvent\Type;

final class RawContentBlockDeltaEvent implements BaseModel
{
    use Model;

    #[Api]
    public CitationsDelta|InputJSONDelta|SignatureDelta|TextDelta|ThinkingDelta $delta;

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
        CitationsDelta|InputJSONDelta|SignatureDelta|TextDelta|ThinkingDelta $delta,
        int $index,
        string $type = 'content_block_delta',
    ) {
        $this->delta = $delta;
        $this->index = $index;
        $this->type = $type;
    }
}

RawContentBlockDeltaEvent::_loadMetadata();
