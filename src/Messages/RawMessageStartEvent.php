<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type RawMessageStartEventShape = array{
 *   message: Message, type: 'message_start'
 * }
 */
final class RawMessageStartEvent implements BaseModel
{
    /** @use SdkModel<RawMessageStartEventShape> */
    use SdkModel;

    /** @var 'message_start' $type */
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
