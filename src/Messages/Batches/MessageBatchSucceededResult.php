<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Message;

/**
 * @phpstan-type MessageBatchSucceededResultShape = array{
 *   message: Message, type: "succeeded"
 * }
 */
final class MessageBatchSucceededResult implements BaseModel
{
    /** @use SdkModel<MessageBatchSucceededResultShape> */
    use SdkModel;

    /** @var "succeeded" $type */
    #[Api]
    public string $type = 'succeeded';

    #[Api]
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
