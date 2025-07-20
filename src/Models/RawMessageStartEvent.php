<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type raw_message_start_event_alias = array{
 *   message: Message, type: string
 * }
 */
final class RawMessageStartEvent implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'message_start';

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
