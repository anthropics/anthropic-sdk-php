<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Message;

class MessageBatchSucceededResult implements BaseModel
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

MessageBatchSucceededResult::_loadMetadata();
