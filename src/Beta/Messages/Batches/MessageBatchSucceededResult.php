<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches;

use Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultBlock;
use Anthropic\Beta\Messages\BetaCodeExecutionToolResultBlock;
use Anthropic\Beta\Messages\BetaContainer;
use Anthropic\Beta\Messages\BetaContainerUploadBlock;
use Anthropic\Beta\Messages\BetaContextManagementResponse;
use Anthropic\Beta\Messages\BetaMCPToolResultBlock;
use Anthropic\Beta\Messages\BetaMCPToolUseBlock;
use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Beta\Messages\BetaRedactedThinkingBlock;
use Anthropic\Beta\Messages\BetaServerToolUseBlock;
use Anthropic\Beta\Messages\BetaStopReason;
use Anthropic\Beta\Messages\BetaTextBlock;
use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultBlock;
use Anthropic\Beta\Messages\BetaThinkingBlock;
use Anthropic\Beta\Messages\BetaToolSearchToolResultBlock;
use Anthropic\Beta\Messages\BetaToolUseBlock;
use Anthropic\Beta\Messages\BetaUsage;
use Anthropic\Beta\Messages\BetaWebFetchToolResultBlock;
use Anthropic\Beta\Messages\BetaWebSearchToolResultBlock;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Model;

/**
 * @phpstan-type MessageBatchSucceededResultShape = array{
 *   message: BetaMessage, type?: 'succeeded'
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
    public BetaMessage $message;

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
        $self = new self;

        $self['message'] = $message;

        return $self;
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
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
