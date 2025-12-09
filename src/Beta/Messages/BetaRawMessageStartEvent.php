<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Model;

/**
 * @phpstan-type BetaRawMessageStartEventShape = array{
 *   message: BetaMessage, type?: 'message_start'
 * }
 */
final class BetaRawMessageStartEvent implements BaseModel
{
    /** @use SdkModel<BetaRawMessageStartEventShape> */
    use SdkModel;

    /** @var 'message_start' $type */
    #[Required]
    public string $type = 'message_start';

    #[Required]
    public BetaMessage $message;

    /**
     * `new BetaRawMessageStartEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRawMessageStartEvent::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaRawMessageStartEvent)->withMessage(...)
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
     * @param BetaMessage|array{
     *   id: string,
     *   container: BetaContainer|null,
     *   content: list<BetaTextBlock|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaWebFetchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaBashCodeExecutionToolResultBlock|BetaTextEditorCodeExecutionToolResultBlock|BetaToolSearchToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock>,
     *   contextManagement: BetaContextManagementResponse|null,
     *   model: string|value-of<Model>,
     *   role?: 'assistant',
     *   stopReason: value-of<BetaStopReason>|null,
     *   stopSequence: string|null,
     *   type?: 'message',
     *   usage: BetaUsage,
     * } $message
     */
    public static function with(BetaMessage|array $message): self
    {
        $obj = new self;

        $obj['message'] = $message;

        return $obj;
    }

    /**
     * @param BetaMessage|array{
     *   id: string,
     *   container: BetaContainer|null,
     *   content: list<BetaTextBlock|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaWebFetchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaBashCodeExecutionToolResultBlock|BetaTextEditorCodeExecutionToolResultBlock|BetaToolSearchToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock>,
     *   contextManagement: BetaContextManagementResponse|null,
     *   model: string|value-of<Model>,
     *   role?: 'assistant',
     *   stopReason: value-of<BetaStopReason>|null,
     *   stopSequence: string|null,
     *   type?: 'message',
     *   usage: BetaUsage,
     * } $message
     */
    public function withMessage(BetaMessage|array $message): self
    {
        $obj = clone $this;
        $obj['message'] = $message;

        return $obj;
    }
}
