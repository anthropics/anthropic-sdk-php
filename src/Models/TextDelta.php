<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class TextDelta implements BaseModel
{
    use Model;

    #[Api]
    public string $text;

    #[Api]
    public string $type;

    /**
     * @param string $text
     * @param string $type
     */
    final public function __construct($text, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

TextDelta::_loadMetadata();
