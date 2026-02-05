<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaRawContentBlockStartEvent\ContentBlock;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ContentBlockVariants from \Anthropic\Beta\Messages\BetaRawContentBlockStartEvent\ContentBlock
 * @phpstan-import-type ContentBlockShape from \Anthropic\Beta\Messages\BetaRawContentBlockStartEvent\ContentBlock
 *
 * @phpstan-type BetaRawContentBlockStartEventShape = array{
 *   contentBlock: ContentBlockShape, index: int, type: 'content_block_start'
 * }
 */
final class BetaRawContentBlockStartEvent implements BaseModel
{
    /** @use SdkModel<BetaRawContentBlockStartEventShape> */
    use SdkModel;

    /** @var 'content_block_start' $type */
    #[Required]
    public string $type = 'content_block_start';

    /**
     * Response model for a file uploaded to the container.
     *
     * @var ContentBlockVariants $contentBlock
     */
    #[Required('content_block', union: ContentBlock::class)]
    public BetaTextBlock|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaWebFetchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaBashCodeExecutionToolResultBlock|BetaTextEditorCodeExecutionToolResultBlock|BetaToolSearchToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock|BetaCompactionBlock $contentBlock;

    #[Required]
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
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param ContentBlockShape $contentBlock
     */
    public static function with(
        BetaTextBlock|array|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaWebFetchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaBashCodeExecutionToolResultBlock|BetaTextEditorCodeExecutionToolResultBlock|BetaToolSearchToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock|BetaCompactionBlock $contentBlock,
        int $index,
    ): self {
        $self = new self;

        $self['contentBlock'] = $contentBlock;
        $self['index'] = $index;

        return $self;
    }

    /**
     * Response model for a file uploaded to the container.
     *
     * @param ContentBlockShape $contentBlock
     */
    public function withContentBlock(
        BetaTextBlock|array|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaWebFetchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaBashCodeExecutionToolResultBlock|BetaTextEditorCodeExecutionToolResultBlock|BetaToolSearchToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock|BetaCompactionBlock $contentBlock,
    ): self {
        $self = clone $this;
        $self['contentBlock'] = $contentBlock;

        return $self;
    }

    public function withIndex(int $index): self
    {
        $self = clone $this;
        $self['index'] = $index;

        return $self;
    }

    /**
     * @param 'content_block_start' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
