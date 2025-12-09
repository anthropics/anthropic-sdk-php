<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaMessageDeltaUsageShape = array{
 *   cacheCreationInputTokens: int|null,
 *   cacheReadInputTokens: int|null,
 *   inputTokens: int|null,
 *   outputTokens: int,
 *   serverToolUse: BetaServerToolUsage|null,
 * }
 */
final class BetaMessageDeltaUsage implements BaseModel
{
    /** @use SdkModel<BetaMessageDeltaUsageShape> */
    use SdkModel;

    /**
     * The cumulative number of input tokens used to create the cache entry.
     */
    #[Required('cache_creation_input_tokens')]
    public ?int $cacheCreationInputTokens;

    /**
     * The cumulative number of input tokens read from the cache.
     */
    #[Required('cache_read_input_tokens')]
    public ?int $cacheReadInputTokens;

    /**
     * The cumulative number of input tokens which were used.
     */
    #[Required('input_tokens')]
    public ?int $inputTokens;

    /**
     * The cumulative number of output tokens which were used.
     */
    #[Required('output_tokens')]
    public int $outputTokens;

    /**
     * The number of server tool requests.
     */
    #[Required('server_tool_use')]
    public ?BetaServerToolUsage $serverToolUse;

    /**
     * `new BetaMessageDeltaUsage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMessageDeltaUsage::with(
     *   cacheCreationInputTokens: ...,
     *   cacheReadInputTokens: ...,
     *   inputTokens: ...,
     *   outputTokens: ...,
     *   serverToolUse: ...,
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
     *   webFetchRequests: int, webSearchRequests: int
     * }|null $serverToolUse
     */
    public static function with(
        ?int $cacheCreationInputTokens,
        ?int $cacheReadInputTokens,
        ?int $inputTokens,
        int $outputTokens,
        BetaServerToolUsage|array|null $serverToolUse,
    ): self {
        $obj = new self;

        $obj['cacheCreationInputTokens'] = $cacheCreationInputTokens;
        $obj['cacheReadInputTokens'] = $cacheReadInputTokens;
        $obj['inputTokens'] = $inputTokens;
        $obj['outputTokens'] = $outputTokens;
        $obj['serverToolUse'] = $serverToolUse;

        return $obj;
    }

    /**
     * The cumulative number of input tokens used to create the cache entry.
     */
    public function withCacheCreationInputTokens(
        ?int $cacheCreationInputTokens
    ): self {
        $obj = clone $this;
        $obj['cacheCreationInputTokens'] = $cacheCreationInputTokens;

        return $obj;
    }

    /**
     * The cumulative number of input tokens read from the cache.
     */
    public function withCacheReadInputTokens(?int $cacheReadInputTokens): self
    {
        $obj = clone $this;
        $obj['cacheReadInputTokens'] = $cacheReadInputTokens;

        return $obj;
    }

    /**
     * The cumulative number of input tokens which were used.
     */
    public function withInputTokens(?int $inputTokens): self
    {
        $obj = clone $this;
        $obj['inputTokens'] = $inputTokens;

        return $obj;
    }

    /**
     * The cumulative number of output tokens which were used.
     */
    public function withOutputTokens(int $outputTokens): self
    {
        $obj = clone $this;
        $obj['outputTokens'] = $outputTokens;

        return $obj;
    }

    /**
     * The number of server tool requests.
     *
     * @param BetaServerToolUsage|array{
     *   webFetchRequests: int, webSearchRequests: int
     * }|null $serverToolUse
     */
    public function withServerToolUse(
        BetaServerToolUsage|array|null $serverToolUse
    ): self {
        $obj = clone $this;
        $obj['serverToolUse'] = $serverToolUse;

        return $obj;
    }
}
