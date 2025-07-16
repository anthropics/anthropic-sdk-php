<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class RawContentBlockDeltaEvent implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'content_block_delta';

    #[Api]
    public CitationsDelta|InputJSONDelta|SignatureDelta|TextDelta|ThinkingDelta $delta;

    #[Api]
    public int $index;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        CitationsDelta|InputJSONDelta|SignatureDelta|TextDelta|ThinkingDelta $delta,
        int $index,
    ) {
        $this->delta = $delta;
        $this->index = $index;

        self::_introspect();
    }
}
