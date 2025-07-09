<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class ThinkingConfigDisabled implements BaseModel
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

ThinkingConfigDisabled::_loadMetadata();
