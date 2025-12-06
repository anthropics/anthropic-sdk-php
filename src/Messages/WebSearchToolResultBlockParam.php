<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\CacheControlEphemeral\TTL;
use Anthropic\Messages\WebSearchToolRequestError\ErrorCode;

/**
 * @phpstan-type WebSearchToolResultBlockParamShape = array{
 *   content: list<WebSearchResultBlockParam>|WebSearchToolRequestError,
 *   tool_use_id: string,
 *   type: 'web_search_tool_result',
 *   cache_control?: CacheControlEphemeral|null,
 * }
 */
final class WebSearchToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<WebSearchToolResultBlockParamShape> */
    use SdkModel;

    /** @var 'web_search_tool_result' $type */
    #[Api]
    public string $type = 'web_search_tool_result';

    /** @var list<WebSearchResultBlockParam>|WebSearchToolRequestError $content */
    #[Api(union: WebSearchToolResultBlockParamContent::class)]
    public array|WebSearchToolRequestError $content;

    #[Api]
    public string $tool_use_id;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?CacheControlEphemeral $cache_control;

    /**
     * `new WebSearchToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebSearchToolResultBlockParam::with(content: ..., tool_use_id: ...)
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
     *   encrypted_content: string,
     *   title: string,
     *   type: 'web_search_result',
     *   url: string,
     *   page_age?: string|null,
     * }>|WebSearchToolRequestError|array{
     *   error_code: value-of<ErrorCode>, type: 'web_search_tool_result_error'
     * } $content
     * @param CacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cache_control
     */
    public static function with(
        array|WebSearchToolRequestError $content,
        string $tool_use_id,
        CacheControlEphemeral|array|null $cache_control = null,
    ): self {
        $obj = new self;

        $obj['content'] = $content;
        $obj['tool_use_id'] = $tool_use_id;

        null !== $cache_control && $obj['cache_control'] = $cache_control;

        return $obj;
    }

    /**
     * @param list<WebSearchResultBlockParam|array{
     *   encrypted_content: string,
     *   title: string,
     *   type: 'web_search_result',
     *   url: string,
     *   page_age?: string|null,
     * }>|WebSearchToolRequestError|array{
     *   error_code: value-of<ErrorCode>, type: 'web_search_tool_result_error'
     * } $content
     */
    public function withContent(array|WebSearchToolRequestError $content): self
    {
        $obj = clone $this;
        $obj['content'] = $content;

        return $obj;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $obj = clone $this;
        $obj['tool_use_id'] = $toolUseID;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param CacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        CacheControlEphemeral|array|null $cacheControl
    ): self {
        $obj = clone $this;
        $obj['cache_control'] = $cacheControl;

        return $obj;
    }
}
