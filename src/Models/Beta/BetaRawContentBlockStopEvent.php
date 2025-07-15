<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaRawContentBlockStopEvent implements BaseModel
{
    use Model;

    #[Api]
    public int $index;

    #[Api]
    public string $type = 'content_block_stop';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        int $index,
        string $type = 'content_block_stop'
    ) {
        $this->index = $index;
        $this->type = $type;
    }
}

BetaRawContentBlockStopEvent::_loadMetadata();
