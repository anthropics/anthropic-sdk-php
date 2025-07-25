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

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function new(Message $message): self
    {
        $obj = new self;

        $obj->message = $message;

        return $obj;
    }

    public function setMessage(Message $message): self
    {
        $this->message = $message;

        return $this;
    }
}
