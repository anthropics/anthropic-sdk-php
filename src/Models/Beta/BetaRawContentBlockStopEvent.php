<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaRawContentBlockStopEvent implements BaseModel
{
    use Model;

    #[Api]
    public int $index;

    #[Api]
    public string $type;

    /**
     * @param int    $index
     * @param string $type
     */
    final public function __construct($index, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaRawContentBlockStopEvent::_loadMetadata();
