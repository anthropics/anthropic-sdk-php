<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\WebSearchToolResultError\ErrorCode;

/**
 * @phpstan-type WebSearchToolResultBlockShape = array{
 *   content: WebSearchToolResultError|list<WebSearchResultBlock>,
 *   toolUseID: string,
 *   type?: 'web_search_tool_result',
 * }
 */
final class WebSearchToolResultBlock implements BaseModel
{
    /** @use SdkModel<WebSearchToolResultBlockShape> */
    use SdkModel;

    /** @var 'web_search_tool_result' $type */
    #[Required]
    public string $type = 'web_search_tool_result';

    /** @var WebSearchToolResultError|list<WebSearchResultBlock> $content */
    #[Required(union: WebSearchToolResultBlockContent::class)]
    public WebSearchToolResultError|array $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * `new WebSearchToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebSearchToolResultBlock::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebSearchToolResultBlock)->withContent(...)->withToolUseID(...)
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
     * @param WebSearchToolResultError|array{
     *   errorCode: value-of<ErrorCode>, type?: 'web_search_tool_result_error'
     * }|list<WebSearchResultBlock|array{
     *   encryptedContent: string,
     *   pageAge: string|null,
     *   title: string,
     *   type?: 'web_search_result',
     *   url: string,
     * }> $content
     */
    public static function with(
        WebSearchToolResultError|array $content,
        string $toolUseID
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['toolUseID'] = $toolUseID;

        return $self;
    }

    /**
     * @param WebSearchToolResultError|array{
     *   errorCode: value-of<ErrorCode>, type?: 'web_search_tool_result_error'
     * }|list<WebSearchResultBlock|array{
     *   encryptedContent: string,
     *   pageAge: string|null,
     *   title: string,
     *   type?: 'web_search_result',
     *   url: string,
     * }> $content
     */
    public function withContent(WebSearchToolResultError|array $content): self
    {
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
