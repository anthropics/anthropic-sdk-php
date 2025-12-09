<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebSearchToolResultBlockParamShape = array{
 *   content: list<BetaWebSearchResultBlockParam>|BetaWebSearchToolRequestError,
 *   toolUseID: string,
 *   type?: 'web_search_tool_result',
 *   cacheControl?: BetaCacheControlEphemeral|null,
 * }
 */
final class BetaWebSearchToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaWebSearchToolResultBlockParamShape> */
    use SdkModel;

    /** @var 'web_search_tool_result' $type */
    #[Required]
    public string $type = 'web_search_tool_result';

    /** @var list<BetaWebSearchResultBlockParam>|BetaWebSearchToolRequestError $content */
    #[Required(union: BetaWebSearchToolResultBlockParamContent::class)]
    public array|BetaWebSearchToolRequestError $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * `new BetaWebSearchToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebSearchToolResultBlockParam::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebSearchToolResultBlockParam)->withContent(...)->withToolUseID(...)
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
     * @param list<BetaWebSearchResultBlockParam|array{
     *   encryptedContent: string,
     *   title: string,
     *   type?: 'web_search_result',
     *   url: string,
     *   pageAge?: string|null,
     * }>|BetaWebSearchToolRequestError|array{
     *   errorCode: value-of<BetaWebSearchToolResultErrorCode>,
     *   type?: 'web_search_tool_result_error',
     * } $content
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public static function with(
        array|BetaWebSearchToolRequestError $content,
        string $toolUseID,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['toolUseID'] = $toolUseID;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * @param list<BetaWebSearchResultBlockParam|array{
     *   encryptedContent: string,
     *   title: string,
     *   type?: 'web_search_result',
     *   url: string,
     *   pageAge?: string|null,
     * }>|BetaWebSearchToolRequestError|array{
     *   errorCode: value-of<BetaWebSearchToolResultErrorCode>,
     *   type?: 'web_search_tool_result_error',
     * } $content
     */
    public function withContent(
        array|BetaWebSearchToolRequestError $content
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
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }
}
