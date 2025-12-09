<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Beta\Messages\BetaToolSearchToolResultErrorParam\ErrorCode;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaToolSearchToolResultBlockParamShape = array{
 *   content: BetaToolSearchToolResultErrorParam|BetaToolSearchToolSearchResultBlockParam,
 *   toolUseID: string,
 *   type?: 'tool_search_tool_result',
 *   cacheControl?: BetaCacheControlEphemeral|null,
 * }
 */
final class BetaToolSearchToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaToolSearchToolResultBlockParamShape> */
    use SdkModel;

    /** @var 'tool_search_tool_result' $type */
    #[Required]
    public string $type = 'tool_search_tool_result';

    #[Required]
    public BetaToolSearchToolResultErrorParam|BetaToolSearchToolSearchResultBlockParam $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * `new BetaToolSearchToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolSearchToolResultBlockParam::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolSearchToolResultBlockParam)->withContent(...)->withToolUseID(...)
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
     * @param BetaToolSearchToolResultErrorParam|array{
     *   errorCode: value-of<ErrorCode>, type?: 'tool_search_tool_result_error'
     * }|BetaToolSearchToolSearchResultBlockParam|array{
     *   toolReferences: list<BetaToolReferenceBlockParam>,
     *   type?: 'tool_search_tool_search_result',
     * } $content
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public static function with(
        BetaToolSearchToolResultErrorParam|array|BetaToolSearchToolSearchResultBlockParam $content,
        string $toolUseID,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
    ): self {
        $obj = new self;

        $obj['content'] = $content;
        $obj['toolUseID'] = $toolUseID;

        null !== $cacheControl && $obj['cacheControl'] = $cacheControl;

        return $obj;
    }

    /**
     * @param BetaToolSearchToolResultErrorParam|array{
     *   errorCode: value-of<ErrorCode>, type?: 'tool_search_tool_result_error'
     * }|BetaToolSearchToolSearchResultBlockParam|array{
     *   toolReferences: list<BetaToolReferenceBlockParam>,
     *   type?: 'tool_search_tool_search_result',
     * } $content
     */
    public function withContent(
        BetaToolSearchToolResultErrorParam|array|BetaToolSearchToolSearchResultBlockParam $content,
    ): self {
        $obj = clone $this;
        $obj['content'] = $content;

        return $obj;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $obj = clone $this;
        $obj['toolUseID'] = $toolUseID;

        return $obj;
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
        $obj = clone $this;
        $obj['cacheControl'] = $cacheControl;

        return $obj;
    }
}
