<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaWebSearchToolRequestError implements BaseModel
{
    use Model;

    #[Api('error_code')]
    public string $errorCode;

    #[Api]
    public string $type;

    /**
     * @param string $errorCode
     * @param string $type
     */
    final public function __construct($errorCode, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaWebSearchToolRequestError::_loadMetadata();
