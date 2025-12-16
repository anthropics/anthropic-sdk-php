<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Message;

/**
 * @phpstan-import-type MessageShape from \Anthropic\Messages\Message
 *
 * @phpstan-type MessageBatchSucceededResultShape = array{
 *   message: Message|MessageShape, type: 'succeeded'
 * }
 */
final class MessageBatchSucceededResult implements BaseModel
{
    /** @use SdkModel<MessageBatchSucceededResultShape> */
    use SdkModel;

    /** @var 'succeeded' $type */
    #[Required]
    public string $type = 'succeeded';

    #[Required]
    public Message $message;

    /**
     * `new MessageBatchSucceededResult()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageBatchSucceededResult::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MessageBatchSucceededResult)->withMessage(...)
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
