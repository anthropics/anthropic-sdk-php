<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebFetchToolResultBlockParamShape = array{
 *   content: BetaWebFetchToolResultErrorBlockParam|BetaWebFetchBlockParam,
 *   toolUseID: string,
 *   type?: 'web_fetch_tool_result',
 *   cacheControl?: BetaCacheControlEphemeral|null,
 * }
 */
final class BetaWebFetchToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaWebFetchToolResultBlockParamShape> */
    use SdkModel;

    /** @var 'web_fetch_tool_result' $type */
    #[Required]
    public string $type = 'web_fetch_tool_result';

    #[Required]
    public BetaWebFetchToolResultErrorBlockParam|BetaWebFetchBlockParam $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * `new BetaWebFetchToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebFetchToolResultBlockParam::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebFetchToolResultBlockParam)->withContent(...)->withToolUseID(...)
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
     * @param BetaWebFetchToolResultErrorBlockParam|array{
     *   errorCode: value-of<BetaWebFetchToolResultErrorCode>,
     *   type?: 'web_fetch_tool_result_error',
     * }|BetaWebFetchBlockParam|array{
     *   content: BetaRequestDocumentBlock,
     *   type?: 'web_fetch_result',
     *   url: string,
     *   retrievedAt?: string|null,
     * } $content
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public static function with(
        BetaWebFetchToolResultErrorBlockParam|array|BetaWebFetchBlockParam $content,
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
     * @param BetaWebFetchToolResultErrorBlockParam|array{
     *   errorCode: value-of<BetaWebFetchToolResultErrorCode>,
     *   type?: 'web_fetch_tool_result_error',
     * }|BetaWebFetchBlockParam|array{
     *   content: BetaRequestDocumentBlock,
     *   type?: 'web_fetch_result',
     *   url: string,
     *   retrievedAt?: string|null,
     * } $content
     */
    public function withContent(
        BetaWebFetchToolResultErrorBlockParam|array|BetaWebFetchBlockParam $content
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
