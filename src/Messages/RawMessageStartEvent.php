<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type raw_message_start_event_alias = array{
 *   message: Message, type: string
 * }
 */
final class RawMessageStartEvent implements BaseModel
{
    use SdkModel;

    #[Api]
    public string $type = 'message_start';

    #[Api]
    public Message $message;

    /**
     * `new RawMessageStartEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RawMessageStartEvent::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RawMessageStartEvent)->withMessage(...)
     * ```
     */
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
    public static function with(Message $message): self
    {
        $obj = new self;

        $obj->message = $message;

        return $obj;
    }

    public function withMessage(Message $message): self
    {
        $obj = clone $this;
        $obj->message = $message;

        return $obj;
    }
}
