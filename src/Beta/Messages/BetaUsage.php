<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaUsage\ServiceTier;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaUsageShape = array{
 *   cacheCreation: BetaCacheCreation|null,
 *   cacheCreationInputTokens: int|null,
 *   cacheReadInputTokens: int|null,
 *   inputTokens: int,
 *   outputTokens: int,
 *   serverToolUse: BetaServerToolUsage|null,
 *   serviceTier: value-of<ServiceTier>|null,
 * }
 */
final class BetaUsage implements BaseModel
{
    /** @use SdkModel<BetaUsageShape> */
    use SdkModel;

    /**
     * Breakdown of cached tokens by TTL.
     */
    #[Required('cache_creation')]
    public ?BetaCacheCreation $cacheCreation;

    /**
     * The number of input tokens used to create the cache entry.
     */
    #[Required('cache_creation_input_tokens')]
    public ?int $cacheCreationInputTokens;

    /**
     * The number of input tokens read from the cache.
     */
    #[Required('cache_read_input_tokens')]
    public ?int $cacheReadInputTokens;

    /**
     * The number of input tokens which were used.
     */
    #[Required('input_tokens')]
    public int $inputTokens;

    /**
     * The number of output tokens which were used.
     */
    #[Required('output_tokens')]
    public int $outputTokens;

    /**
     * The number of server tool requests.
     */
    #[Required('server_tool_use')]
    public ?BetaServerToolUsage $serverToolUse;

    /**
     * If the request used the priority, standard, or batch tier.
     *
     * @var value-of<ServiceTier>|null $serviceTier
     */
    #[Required('service_tier', enum: ServiceTier::class)]
    public ?string $serviceTier;

    /**
     * `new BetaUsage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaUsage::with(
     *   cacheCreation: ...,
     *   cacheCreationInputTokens: ...,
     *   cacheReadInputTokens: ...,
     *   inputTokens: ...,
     *   outputTokens: ...,
     *   serverToolUse: ...,
     *   serviceTier: ...,
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
     *   ephemeral1hInputTokens: int, ephemeral5mInputTokens: int
     * }|null $cacheCreation
     * @param BetaServerToolUsage|array{
     *   webFetchRequests: int, webSearchRequests: int
     * }|null $serverToolUse
     * @param ServiceTier|value-of<ServiceTier>|null $serviceTier
     */
    public static function with(
        BetaCacheCreation|array|null $cacheCreation,
        ?int $cacheCreationInputTokens,
        ?int $cacheReadInputTokens,
        int $inputTokens,
        int $outputTokens,
        BetaServerToolUsage|array|null $serverToolUse,
        ServiceTier|string|null $serviceTier,
    ): self {
        $obj = new self;

        $obj['cacheCreation'] = $cacheCreation;
        $obj['cacheCreationInputTokens'] = $cacheCreationInputTokens;
        $obj['cacheReadInputTokens'] = $cacheReadInputTokens;
        $obj['inputTokens'] = $inputTokens;
        $obj['outputTokens'] = $outputTokens;
        $obj['serverToolUse'] = $serverToolUse;
        $obj['serviceTier'] = $serviceTier;

        return $obj;
    }

    /**
     * Breakdown of cached tokens by TTL.
     *
     * @param BetaCacheCreation|array{
     *   ephemeral1hInputTokens: int, ephemeral5mInputTokens: int
     * }|null $cacheCreation
     */
    public function withCacheCreation(
        BetaCacheCreation|array|null $cacheCreation
    ): self {
        $obj = clone $this;
        $obj['cacheCreation'] = $cacheCreation;

        return $obj;
    }

    /**
     * The number of input tokens used to create the cache entry.
     */
    public function withCacheCreationInputTokens(
        ?int $cacheCreationInputTokens
    ): self {
        $obj = clone $this;
        $obj['cacheCreationInputTokens'] = $cacheCreationInputTokens;

        return $obj;
    }

    /**
     * The number of input tokens read from the cache.
     */
    public function withCacheReadInputTokens(?int $cacheReadInputTokens): self
    {
        $obj = clone $this;
        $obj['cacheReadInputTokens'] = $cacheReadInputTokens;

        return $obj;
    }

    /**
     * The number of input tokens which were used.
     */
    public function withInputTokens(int $inputTokens): self
    {
        $obj = clone $this;
        $obj['inputTokens'] = $inputTokens;

        return $obj;
    }

    /**
     * The number of output tokens which were used.
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

    /**
     * If the request used the priority, standard, or batch tier.
     *
     * @param ServiceTier|value-of<ServiceTier>|null $serviceTier
     */
    public function withServiceTier(ServiceTier|string|null $serviceTier): self
    {
        $obj = clone $this;
        $obj['serviceTier'] = $serviceTier;

        return $obj;
    }
}
