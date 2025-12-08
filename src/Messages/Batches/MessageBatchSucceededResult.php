<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Message;
use Anthropic\Messages\Model;
use Anthropic\Messages\RedactedThinkingBlock;
use Anthropic\Messages\ServerToolUseBlock;
use Anthropic\Messages\StopReason;
use Anthropic\Messages\TextBlock;
use Anthropic\Messages\ThinkingBlock;
use Anthropic\Messages\ToolUseBlock;
use Anthropic\Messages\Usage;
use Anthropic\Messages\WebSearchToolResultBlock;

/**
 * @phpstan-type MessageBatchSucceededResultShape = array{
 *   message: Message, type: 'succeeded'
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
     * @param Message|array{
     *   id: string,
     *   content: list<TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock>,
     *   model: string|value-of<Model>,
     *   role: 'assistant',
     *   stop_reason: value-of<StopReason>|null,
     *   stop_sequence: string|null,
     *   type: 'message',
     *   usage: Usage,
     * } $message
     */
    public static function with(Message|array $message): self
    {
        $obj = new self;

        $obj['message'] = $message;

        return $obj;
    }

    /**
     * @param Message|array{
     *   id: string,
     *   content: list<TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock>,
     *   model: string|value-of<Model>,
     *   role: 'assistant',
     *   stop_reason: value-of<StopReason>|null,
     *   stop_sequence: string|null,
     *   type: 'message',
     *   usage: Usage,
     * } $message
     */
    public function withMessage(Message|array $message): self
    {
        $obj = clone $this;
        $obj['message'] = $message;

        return $obj;
    }
}
