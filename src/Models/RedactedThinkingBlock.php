<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class RedactedThinkingBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $data;

    #[Api]
    public string $type;

    /**
     * @param string $data
     * @param string $type
     */
    final public function __construct($data, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

RedactedThinkingBlock::_loadMetadata();
