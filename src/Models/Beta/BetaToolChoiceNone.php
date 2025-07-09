<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaToolChoiceNone implements BaseModel
{
    use Model;

    #[Api]
    public string $type;

    /** @param string $type */
    final public function __construct($type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaToolChoiceNone::_loadMetadata();
