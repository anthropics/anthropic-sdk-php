<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaInputJSONDelta implements BaseModel
{
    use Model;

    #[Api('partial_json')]
    public string $partialJSON;

    #[Api]
    public string $type;

    /**
     * @param string $partialJSON
     * @param string $type
     */
    final public function __construct($partialJSON, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaInputJSONDelta::_loadMetadata();
