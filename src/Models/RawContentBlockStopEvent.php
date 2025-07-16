<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\RawContentBlockStopEvent\Type;

final class RawContentBlockStopEvent implements BaseModel
{
    use Model;

    #[Api]
    public int $index;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'content_block_stop';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        int $index,
        string $type = 'content_block_stop'
    ) {
        $this->index = $index;
        $this->type = $type;
    }
}

RawContentBlockStopEvent::_loadMetadata();
