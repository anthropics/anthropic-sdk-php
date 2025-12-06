<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaMessageDeltaUsageShape = array{
 *   cache_creation_input_tokens: int|null,
 *   cache_read_input_tokens: int|null,
 *   input_tokens: int|null,
 *   output_tokens: int,
 *   server_tool_use: BetaServerToolUsage|null,
 * }
 */
final class BetaMessageDeltaUsage implements BaseModel
{
    /** @use SdkModel<BetaMessageDeltaUsageShape> */
    use SdkModel;

    /**
     * The cumulative number of input tokens used to create the cache entry.
     */
    #[Api]
    public ?int $cache_creation_input_tokens;

    /**
     * The cumulative number of input tokens read from the cache.
     */
    #[Api]
    public ?int $cache_read_input_tokens;

    /**
     * The cumulative number of input tokens which were used.
     */
    #[Api]
    public ?int $input_tokens;

    /**
     * The cumulative number of output tokens which were used.
     */
    #[Api]
    public int $output_tokens;

    /**
     * The number of server tool requests.
     */
    #[Api]
    public ?BetaServerToolUsage $server_tool_use;

    /**
     * `new BetaMessageDeltaUsage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMessageDeltaUsage::with(
     *   cache_creation_input_tokens: ...,
     *   cache_read_input_tokens: ...,
     *   input_tokens: ...,
     *   output_tokens: ...,
     *   server_tool_use: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaMessageDeltaUsage)
     *   ->withCacheCreationInputTokens(...)
     *   ->withCacheReadInputTokens(...)
     *   ->withInputTokens(...)
     *   ->withOutputTokens(...)
     *   ->withServerToolUse(...)
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
     * @param BetaServerToolUsage|array{
     *   web_fetch_requests: int, web_search_requests: int
     * }|null $server_tool_use
     */
    public static function with(
        ?int $cache_creation_input_tokens,
        ?int $cache_read_input_tokens,
        ?int $input_tokens,
        int $output_tokens,
        BetaServerToolUsage|array|null $server_tool_use,
    ): self {
        $obj = new self;

        $obj['cache_creation_input_tokens'] = $cache_creation_input_tokens;
        $obj['cache_read_input_tokens'] = $cache_read_input_tokens;
        $obj['input_tokens'] = $input_tokens;
        $obj['output_tokens'] = $output_tokens;
        $obj['server_tool_use'] = $server_tool_use;

        return $obj;
    }

    /**
     * The cumulative number of input tokens used to create the cache entry.
     */
    public function withCacheCreationInputTokens(
        ?int $cacheCreationInputTokens
    ): self {
        $obj = clone $this;
        $obj['cache_creation_input_tokens'] = $cacheCreationInputTokens;

        return $obj;
    }

    /**
     * The cumulative number of input tokens read from the cache.
     */
    public function withCacheReadInputTokens(?int $cacheReadInputTokens): self
    {
        $obj = clone $this;
        $obj['cache_read_input_tokens'] = $cacheReadInputTokens;

        return $obj;
    }

    /**
     * The cumulative number of input tokens which were used.
     */
    public function withInputTokens(?int $inputTokens): self
    {
        $obj = clone $this;
        $obj['input_tokens'] = $inputTokens;

        return $obj;
    }

    /**
     * The cumulative number of output tokens which were used.
     */
    public function withOutputTokens(int $outputTokens): self
    {
        $obj = clone $this;
        $obj['output_tokens'] = $outputTokens;

        return $obj;
    }

    /**
     * The number of server tool requests.
     *
     * @param BetaServerToolUsage|array{
     *   web_fetch_requests: int, web_search_requests: int
     * }|null $serverToolUse
     */
    public function withServerToolUse(
        BetaServerToolUsage|array|null $serverToolUse
    ): self {
        $obj = clone $this;
        $obj['server_tool_use'] = $serverToolUse;

        return $obj;
    }
}
