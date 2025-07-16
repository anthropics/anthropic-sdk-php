<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\RawMessageStartEvent\Type;

final class RawMessageStartEvent implements BaseModel
{
    use Model;

    #[Api]
    public Message $message;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'message_start';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        Message $message,
        string $type = 'message_start'
    ) {
        $this->message = $message;
        $this->type = $type;
    }
}

RawMessageStartEvent::_loadMetadata();
