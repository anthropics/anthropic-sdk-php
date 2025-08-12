<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type raw_message_start_event_alias = array{
 *   message: Message, type: string
 * }
 */
final class RawMessageStartEvent implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'message_start';

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
