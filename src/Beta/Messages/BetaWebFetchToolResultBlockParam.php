<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebFetchToolResultBlockParamShape = array{
 *   content: BetaWebFetchToolResultErrorBlockParam|BetaWebFetchBlockParam,
 *   tool_use_id: string,
 *   type: 'web_fetch_tool_result',
 *   cache_control?: BetaCacheControlEphemeral|null,
 * }
 */
final class BetaWebFetchToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaWebFetchToolResultBlockParamShape> */
    use SdkModel;

    /** @var 'web_fetch_tool_result' $type */
    #[Api]
    public string $type = 'web_fetch_tool_result';

    #[Api]
    public BetaWebFetchToolResultErrorBlockParam|BetaWebFetchBlockParam $content;

    #[Api]
    public string $tool_use_id;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cache_control;

    /**
     * `new BetaWebFetchToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebFetchToolResultBlockParam::with(content: ..., tool_use_id: ...)
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
     *   error_code: value-of<BetaWebFetchToolResultErrorCode>,
     *   type: 'web_fetch_tool_result_error',
     * }|BetaWebFetchBlockParam|array{
     *   content: BetaRequestDocumentBlock,
     *   type: 'web_fetch_result',
     *   url: string,
     *   retrieved_at?: string|null,
     * } $content
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cache_control
     */
    public static function with(
        BetaWebFetchToolResultErrorBlockParam|array|BetaWebFetchBlockParam $content,
        string $tool_use_id,
        BetaCacheControlEphemeral|array|null $cache_control = null,
    ): self {
        $obj = new self;

        $obj['content'] = $content;
        $obj['tool_use_id'] = $tool_use_id;

        null !== $cache_control && $obj['cache_control'] = $cache_control;

        return $obj;
    }

    /**
     * @param BetaWebFetchToolResultErrorBlockParam|array{
     *   error_code: value-of<BetaWebFetchToolResultErrorCode>,
     *   type: 'web_fetch_tool_result_error',
     * }|BetaWebFetchBlockParam|array{
     *   content: BetaRequestDocumentBlock,
     *   type: 'web_fetch_result',
     *   url: string,
     *   retrieved_at?: string|null,
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
        $obj['tool_use_id'] = $toolUseID;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $obj = clone $this;
        $obj['cache_control'] = $cacheControl;

        return $obj;
    }
}
