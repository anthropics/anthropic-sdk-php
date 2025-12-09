<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\CacheControlEphemeral\TTL;
use Anthropic\Messages\WebSearchToolRequestError\ErrorCode;

/**
 * @phpstan-type WebSearchToolResultBlockParamShape = array{
 *   content: list<WebSearchResultBlockParam>|WebSearchToolRequestError,
 *   toolUseID: string,
 *   type?: 'web_search_tool_result',
 *   cacheControl?: CacheControlEphemeral|null,
 * }
 */
final class WebSearchToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<WebSearchToolResultBlockParamShape> */
    use SdkModel;

    /** @var 'web_search_tool_result' $type */
    #[Required]
    public string $type = 'web_search_tool_result';

    /** @var list<WebSearchResultBlockParam>|WebSearchToolRequestError $content */
    #[Required(union: WebSearchToolResultBlockParamContent::class)]
    public array|WebSearchToolRequestError $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * `new WebSearchToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebSearchToolResultBlockParam::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebSearchToolResultBlockParam)->withContent(...)->withToolUseID(...)
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
     * @param list<WebSearchResultBlockParam|array{
     *   encryptedContent: string,
     *   title: string,
     *   type?: 'web_search_result',
     *   url: string,
     *   pageAge?: string|null,
     * }>|WebSearchToolRequestError|array{
     *   errorCode: value-of<ErrorCode>, type?: 'web_search_tool_result_error'
     * } $content
     * @param CacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public static function with(
        array|WebSearchToolRequestError $content,
        string $toolUseID,
        CacheControlEphemeral|array|null $cacheControl = null,
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['toolUseID'] = $toolUseID;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * @param list<WebSearchResultBlockParam|array{
     *   encryptedContent: string,
     *   title: string,
     *   type?: 'web_search_result',
     *   url: string,
     *   pageAge?: string|null,
     * }>|WebSearchToolRequestError|array{
     *   errorCode: value-of<ErrorCode>, type?: 'web_search_tool_result_error'
     * } $content
     */
    public function withContent(array|WebSearchToolRequestError $content): self
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

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param CacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        CacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }
}
