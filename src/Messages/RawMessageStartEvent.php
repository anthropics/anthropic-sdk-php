<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type MessageShape from \Anthropic\Messages\Message
 *
 * @phpstan-type RawMessageStartEventShape = array{
 *   message: Message|MessageShape, type: 'message_start'
 * }
 */
final class RawMessageStartEvent implements BaseModel
{
    /** @use SdkModel<RawMessageStartEventShape> */
    use SdkModel;

    /** @var 'message_start' $type */
    #[Required]
    public string $type = 'message_start';

    #[Required]
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
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param MessageShape $message
     */
    public static function with(Message|array $message): self
    {
        $self = new self;

        $self['message'] = $message;

        return $self;
    }

    /**
     * @param MessageShape $message
     */
    public function withMessage(Message|array $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
