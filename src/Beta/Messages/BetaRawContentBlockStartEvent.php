<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaRawContentBlockStartEvent\ContentBlock;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaRawContentBlockStartEventShape = array{
 *   content_block: BetaTextBlock|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaWebFetchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaBashCodeExecutionToolResultBlock|BetaTextEditorCodeExecutionToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock,
 *   index: int,
 *   type: "content_block_start",
 * }
 */
final class BetaRawContentBlockStartEvent implements BaseModel
{
    /** @use SdkModel<BetaRawContentBlockStartEventShape> */
    use SdkModel;

    /** @var "content_block_start" $type */
    #[Api]
    public string $type = 'content_block_start';

    /**
     * Response model for a file uploaded to the container.
     */
    #[Api(union: ContentBlock::class)]
    public BetaTextBlock|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaWebFetchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaBashCodeExecutionToolResultBlock|BetaTextEditorCodeExecutionToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock $content_block;

    #[Api]
    public int $index;

    /**
     * `new BetaRawContentBlockStartEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRawContentBlockStartEvent::with(content_block: ..., index: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaRawContentBlockStartEvent)->withContentBlock(...)->withIndex(...)
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
    public static function with(
        BetaTextBlock|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaWebFetchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaBashCodeExecutionToolResultBlock|BetaTextEditorCodeExecutionToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock $content_block,
        int $index,
    ): self {
        $obj = new self;

        $obj->content_block = $content_block;
        $obj->index = $index;

        return $obj;
    }

    /**
     * Response model for a file uploaded to the container.
     */
    public function withContentBlock(
        BetaTextBlock|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaWebFetchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaBashCodeExecutionToolResultBlock|BetaTextEditorCodeExecutionToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock $contentBlock,
    ): self {
        $obj = clone $this;
        $obj->content_block = $contentBlock;

        return $obj;
    }

    public function withIndex(int $index): self
    {
        $obj = clone $this;
        $obj->index = $index;

        return $obj;
    }
}
