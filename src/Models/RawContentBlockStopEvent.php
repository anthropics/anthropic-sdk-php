<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class RawContentBlockStopEvent implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'content_block_stop';

    #[Api]
    public int $index;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(int $index)
    {
        $this->index = $index;

        self::_introspect();
    }
}
