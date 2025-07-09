<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class RawMessageStartEvent implements BaseModel
{
    use Model;

    #[Api]
    public Message $message;

    #[Api]
    public string $type;

    /**
     * @param Message $message
     * @param string  $type
     */
    final public function __construct($message, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

RawMessageStartEvent::_loadMetadata();
