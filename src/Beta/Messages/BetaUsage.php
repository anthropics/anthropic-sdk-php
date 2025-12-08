<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaUsage\ServiceTier;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaUsageShape = array{
 *   cache_creation: BetaCacheCreation|null,
 *   cache_creation_input_tokens: int|null,
 *   cache_read_input_tokens: int|null,
 *   input_tokens: int,
 *   output_tokens: int,
 *   server_tool_use: BetaServerToolUsage|null,
 *   service_tier: value-of<ServiceTier>|null,
 * }
 */
final class BetaUsage implements BaseModel
{
    /** @use SdkModel<BetaUsageShape> */
    use SdkModel;

    /**
     * Breakdown of cached tokens by TTL.
     */
    #[Required]
    public ?BetaCacheCreation $cache_creation;

    /**
     * The number of input tokens used to create the cache entry.
     */
    #[Required]
    public ?int $cache_creation_input_tokens;

    /**
     * The number of input tokens read from the cache.
     */
    #[Required]
    public ?int $cache_read_input_tokens;

    /**
     * The number of input tokens which were used.
     */
    #[Required]
    public int $input_tokens;

    /**
     * The number of output tokens which were used.
     */
    #[Required]
    public int $output_tokens;

    /**
     * The number of server tool requests.
     */
    #[Required]
    public ?BetaServerToolUsage $server_tool_use;

    /**
     * If the request used the priority, standard, or batch tier.
     *
     * @var value-of<ServiceTier>|null $service_tier
     */
    #[Required(enum: ServiceTier::class)]
    public ?string $service_tier;

    /**
     * `new BetaUsage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaUsage::with(
     *   cache_creation: ...,
     *   cache_creation_input_tokens: ...,
     *   cache_read_input_tokens: ...,
     *   input_tokens: ...,
     *   output_tokens: ...,
     *   server_tool_use: ...,
     *   service_tier: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaUsage)
     *   ->withCacheCreation(...)
     *   ->withCacheCreationInputTokens(...)
     *   ->withCacheReadInputTokens(...)
     *   ->withInputTokens(...)
     *   ->withOutputTokens(...)
     *   ->withServerToolUse(...)
     *   ->withServiceTier(...)
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
     * @param BetaCacheCreation|array{
     *   ephemeral_1h_input_tokens: int, ephemeral_5m_input_tokens: int
     * }|null $cache_creation
     * @param BetaServerToolUsage|array{
     *   web_fetch_requests: int, web_search_requests: int
     * }|null $server_tool_use
     * @param ServiceTier|value-of<ServiceTier>|null $service_tier
     */
    public static function with(
        BetaCacheCreation|array|null $cache_creation,
        ?int $cache_creation_input_tokens,
        ?int $cache_read_input_tokens,
        int $input_tokens,
        int $output_tokens,
        BetaServerToolUsage|array|null $server_tool_use,
        ServiceTier|string|null $service_tier,
    ): self {
        $obj = new self;

        $obj['cache_creation'] = $cache_creation;
        $obj['cache_creation_input_tokens'] = $cache_creation_input_tokens;
        $obj['cache_read_input_tokens'] = $cache_read_input_tokens;
        $obj['input_tokens'] = $input_tokens;
        $obj['output_tokens'] = $output_tokens;
        $obj['server_tool_use'] = $server_tool_use;
        $obj['service_tier'] = $service_tier;

        return $obj;
    }

    /**
     * Breakdown of cached tokens by TTL.
     *
     * @param BetaCacheCreation|array{
     *   ephemeral_1h_input_tokens: int, ephemeral_5m_input_tokens: int
     * }|null $cacheCreation
     */
    public function withCacheCreation(
        BetaCacheCreation|array|null $cacheCreation
    ): self {
        $obj = clone $this;
        $obj['cache_creation'] = $cacheCreation;

        return $obj;
    }

    /**
     * The number of input tokens used to create the cache entry.
     */
    public function withCacheCreationInputTokens(
        ?int $cacheCreationInputTokens
    ): self {
        $obj = clone $this;
        $obj['cache_creation_input_tokens'] = $cacheCreationInputTokens;

        return $obj;
    }

    /**
     * The number of input tokens read from the cache.
     */
    public function withCacheReadInputTokens(?int $cacheReadInputTokens): self
    {
        $obj = clone $this;
        $obj['cache_read_input_tokens'] = $cacheReadInputTokens;

        return $obj;
    }

    /**
     * The number of input tokens which were used.
     */
    public function withInputTokens(int $inputTokens): self
    {
        $obj = clone $this;
        $obj['input_tokens'] = $inputTokens;

        return $obj;
    }

    /**
     * The number of output tokens which were used.
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

    /**
     * If the request used the priority, standard, or batch tier.
     *
     * @param ServiceTier|value-of<ServiceTier>|null $serviceTier
     */
    public function withServiceTier(ServiceTier|string|null $serviceTier): self
    {
        $obj = clone $this;
        $obj['service_tier'] = $serviceTier;

        return $obj;
    }
}
