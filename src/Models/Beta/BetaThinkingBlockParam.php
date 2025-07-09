<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaThinkingBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $signature;

    #[Api]
    public string $thinking;

    #[Api]
    public string $type;

    /**
     * @param string $signature
     * @param string $thinking
     * @param string $type
     */
    final public function __construct($signature, $thinking, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaThinkingBlockParam::_loadMetadata();
