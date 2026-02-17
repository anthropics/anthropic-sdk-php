<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ContentVariants from \Anthropic\Messages\ToolSearchToolResultBlock\Content
 * @phpstan-import-type ContentShape from \Anthropic\Messages\ToolSearchToolResultBlock\Content
 *
 * @phpstan-type ToolSearchToolResultBlockShape = array{
 *   content: ContentShape, toolUseID: string, type: 'tool_search_tool_result'
 * }
 */
final class ToolSearchToolResultBlock implements BaseModel
{
    /** @use SdkModel<ToolSearchToolResultBlockShape> */
    use SdkModel;

    /** @var 'tool_search_tool_result' $type */
    #[Required]
    public string $type = 'tool_search_tool_result';

    /** @var ContentVariants $content */
    #[Required]
    public ToolSearchToolResultError|ToolSearchToolSearchResultBlock $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * `new ToolSearchToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ToolSearchToolResultBlock::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ToolSearchToolResultBlock)->withContent(...)->withToolUseID(...)
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
     * @param ContentShape $content
     */
    public static function with(
        ToolSearchToolResultError|array|ToolSearchToolSearchResultBlock $content,
        string $toolUseID,
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['toolUseID'] = $toolUseID;

        return $self;
    }

    /**
     * @param ContentShape $content
     */
    public function withContent(
        ToolSearchToolResultError|array|ToolSearchToolSearchResultBlock $content
    ): self {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $self = clone $this;
        $self['toolUseID'] = $toolUseID;

        return $self;
    }

    /**
     * @param 'tool_search_tool_result' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
