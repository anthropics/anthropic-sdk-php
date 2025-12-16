<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaToolSearchToolResultBlock\Content
 *
 * @phpstan-type BetaToolSearchToolResultBlockShape = array{
 *   content: BetaToolSearchToolResultError|BetaToolSearchToolSearchResultBlock|ContentShape,
 *   toolUseID: string,
 *   type: 'tool_search_tool_result',
 * }
 */
final class BetaToolSearchToolResultBlock implements BaseModel
{
    /** @use SdkModel<BetaToolSearchToolResultBlockShape> */
    use SdkModel;

    /** @var 'tool_search_tool_result' $type */
    #[Required]
    public string $type = 'tool_search_tool_result';

    #[Required]
    public BetaToolSearchToolResultError|BetaToolSearchToolSearchResultBlock $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * `new BetaToolSearchToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolSearchToolResultBlock::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolSearchToolResultBlock)->withContent(...)->withToolUseID(...)
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
        BetaToolSearchToolResultError|array|BetaToolSearchToolSearchResultBlock $content,
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
        BetaToolSearchToolResultError|array|BetaToolSearchToolSearchResultBlock $content,
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
}
