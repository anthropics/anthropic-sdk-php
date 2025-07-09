<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaRawMessageStartEvent implements BaseModel
{
    use Model;

    #[Api]
    public BetaMessage $message;

    #[Api]
    public string $type;

    /**
     * @param BetaMessage $message
     * @param string      $type
     */
    final public function __construct($message, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaRawMessageStartEvent::_loadMetadata();
