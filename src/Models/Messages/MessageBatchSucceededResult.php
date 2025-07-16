<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Message;
use Anthropic\Models\Messages\MessageBatchSucceededResult\Type;

final class MessageBatchSucceededResult implements BaseModel
{
    use Model;

    #[Api]
    public Message $message;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'succeeded';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        Message $message,
        string $type = 'succeeded'
    ) {
        $this->message = $message;
        $this->type = $type;
    }
}

MessageBatchSucceededResult::_loadMetadata();
