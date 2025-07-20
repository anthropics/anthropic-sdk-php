<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Message;

/**
 * @phpstan-type message_batch_succeeded_result_alias = array{
 *   message: Message, type: string
 * }
 */
final class MessageBatchSucceededResult implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'succeeded';

    #[Api]
    public Message $message;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(Message $message)
    {
        self::introspect();

        $this->message = $message;
    }
}
