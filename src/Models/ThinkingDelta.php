<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class ThinkingDelta implements BaseModel
{
    use Model;

    #[Api]
    public string $thinking;

    #[Api]
    public string $type;

    /**
     * @param string $thinking
     * @param string $type
     */
    final public function __construct($thinking, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

ThinkingDelta::_loadMetadata();
