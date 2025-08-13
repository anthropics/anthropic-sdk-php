<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaRawContentBlockStartEvent\ContentBlock;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_raw_content_block_start_event_alias = array{
 *   contentBlock: BetaTextBlock|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock,
 *   index: int,
 *   type: string,
 * }
 */
final class BetaRawContentBlockStartEvent implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'content_block_start';

    /**
     * Response model for a file uploaded to the container.
     */
    #[Api('content_block', union: ContentBlock::class)]
    public BetaCodeExecutionToolResultBlock|BetaContainerUploadBlock|BetaMCPToolResultBlock|BetaMCPToolUseBlock|BetaRedactedThinkingBlock|BetaServerToolUseBlock|BetaTextBlock|BetaThinkingBlock|BetaToolUseBlock|BetaWebSearchToolResultBlock $contentBlock;

    #[Api]
    public int $index;

    /**
     * `new BetaRawContentBlockStartEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRawContentBlockStartEvent::with(contentBlock: ..., index: ...)
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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        BetaCodeExecutionToolResultBlock|BetaContainerUploadBlock|BetaMCPToolResultBlock|BetaMCPToolUseBlock|BetaRedactedThinkingBlock|BetaServerToolUseBlock|BetaTextBlock|BetaThinkingBlock|BetaToolUseBlock|BetaWebSearchToolResultBlock $contentBlock,
        int $index,
    ): self {
        $obj = new self;

        $obj->contentBlock = $contentBlock;
        $obj->index = $index;

        return $obj;
    }

    /**
     * Response model for a file uploaded to the container.
     */
    public function withContentBlock(
        BetaCodeExecutionToolResultBlock|BetaContainerUploadBlock|BetaMCPToolResultBlock|BetaMCPToolUseBlock|BetaRedactedThinkingBlock|BetaServerToolUseBlock|BetaTextBlock|BetaThinkingBlock|BetaToolUseBlock|BetaWebSearchToolResultBlock $contentBlock,
    ): self {
        $obj = clone $this;
        $obj->contentBlock = $contentBlock;

        return $obj;
    }

    public function withIndex(int $index): self
    {
        $obj = clone $this;
        $obj->index = $index;

        return $obj;
    }
}
