<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaSignatureDelta implements BaseModel
{
    use Model;

    #[Api]
    public string $signature;

    #[Api]
    public string $type;

    /**
     * @param string $signature
     * @param string $type
     */
    final public function __construct($signature, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaSignatureDelta::_loadMetadata();
