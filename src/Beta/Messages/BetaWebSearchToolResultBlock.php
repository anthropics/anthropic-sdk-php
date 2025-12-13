<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebSearchToolResultBlockShape = array{
 *   content: BetaWebSearchToolResultError|list<BetaWebSearchResultBlock>,
 *   toolUseID: string,
 *   type?: 'web_search_tool_result',
 * }
 */
final class BetaWebSearchToolResultBlock implements BaseModel
{
    /** @use SdkModel<BetaWebSearchToolResultBlockShape> */
    use SdkModel;

    /** @var 'web_search_tool_result' $type */
    #[Required]
    public string $type = 'web_search_tool_result';

    /** @var BetaWebSearchToolResultError|list<BetaWebSearchResultBlock> $content */
    #[Required(union: BetaWebSearchToolResultBlockContent::class)]
    public BetaWebSearchToolResultError|array $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * `new BetaWebSearchToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebSearchToolResultBlock::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebSearchToolResultBlock)->withContent(...)->withToolUseID(...)
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
     * @param BetaWebSearchToolResultError|array{
     *   errorCode: value-of<BetaWebSearchToolResultErrorCode>,
     *   type?: 'web_search_tool_result_error',
     * }|list<BetaWebSearchResultBlock|array{
     *   encryptedContent: string,
     *   pageAge: string|null,
     *   title: string,
     *   type?: 'web_search_result',
     *   url: string,
     * }> $content
     */
    public static function with(
        BetaWebSearchToolResultError|array $content,
        string $toolUseID
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['toolUseID'] = $toolUseID;

        return $self;
    }

    /**
     * @param BetaWebSearchToolResultError|array{
     *   errorCode: value-of<BetaWebSearchToolResultErrorCode>,
     *   type?: 'web_search_tool_result_error',
     * }|list<BetaWebSearchResultBlock|array{
     *   encryptedContent: string,
     *   pageAge: string|null,
     *   title: string,
     *   type?: 'web_search_result',
     *   url: string,
     * }> $content
     */
    public function withContent(
        BetaWebSearchToolResultError|array $content
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
