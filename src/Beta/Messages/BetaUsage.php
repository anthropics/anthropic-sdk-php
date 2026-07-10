<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaUsage\ServiceTier;
use Anthropic\Beta\Messages\BetaUsage\Speed;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaIterationsUsageItemVariants from \Anthropic\Beta\Messages\BetaIterationsUsageItem
 * @phpstan-import-type BetaCacheCreationShape from \Anthropic\Beta\Messages\BetaCacheCreation
 * @phpstan-import-type BetaIterationsUsageItemShape from \Anthropic\Beta\Messages\BetaIterationsUsageItem
 * @phpstan-import-type BetaOutputTokensDetailsShape from \Anthropic\Beta\Messages\BetaOutputTokensDetails
 * @phpstan-import-type BetaServerToolUsageShape from \Anthropic\Beta\Messages\BetaServerToolUsage
 *
 * @phpstan-type BetaUsageShape = array{
 *   cacheCreation: null|BetaCacheCreation|BetaCacheCreationShape,
 *   cacheCreationInputTokens: int|null,
 *   cacheReadInputTokens: int|null,
 *   inferenceGeo: string|null,
 *   inputTokens: int,
 *   iterations: list<BetaIterationsUsageItemShape>|null,
 *   outputTokens: int,
 *   outputTokensDetails: null|BetaOutputTokensDetails|BetaOutputTokensDetailsShape,
 *   serverToolUse: null|BetaServerToolUsage|BetaServerToolUsageShape,
 *   serviceTier: null|ServiceTier|value-of<ServiceTier>,
 *   speed: null|Speed|value-of<Speed>,
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
     * The geographic region where inference was performed for this request.
     */
    #[Required('inference_geo')]
    public ?string $inferenceGeo;

    /**
     * The number of input tokens which were used.
     */
    #[Required('input_tokens')]
    public int $inputTokens;

    /**
     * Per-iteration token usage breakdown.
     *
     * Each entry represents one sampling iteration, with its own input/output token counts and cache statistics. This allows you to:
     * - Determine which iterations exceeded long context thresholds (>=200k tokens)
     * - Calculate the true context window size from the last iteration
     * - Understand token accumulation across server-side tool use loops
     *
     * @var list<BetaIterationsUsageItemVariants>|null $iterations
     */
    #[Required(list: BetaIterationsUsageItem::class)]
    public ?array $iterations;

    /**
     * The number of output tokens which were used.
     */
    #[Required('output_tokens')]
    public int $outputTokens;

    /**
     * Breakdown of output tokens by category.
     *
     * `output_tokens` remains the inclusive, authoritative total used for billing.
     * This object provides a read-only decomposition for observability — for example,
     * how many of the billed output tokens were spent on internal reasoning that may
     * have been summarized before being returned to you.
     */
    #[Required('output_tokens_details')]
    public ?BetaOutputTokensDetails $outputTokensDetails;

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
     * Inference speed mode. `fast` provides significantly faster output token generation at premium pricing. Not all models support `fast`; invalid combinations are rejected at create time.
     *
     * @var value-of<Speed>|null $speed
     */
    #[Required(enum: Speed::class)]
    public ?string $speed;

    /**
     * `new BetaUsage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaUsage::with(
     *   cacheCreation: ...,
     *   cacheCreationInputTokens: ...,
     *   cacheReadInputTokens: ...,
     *   inferenceGeo: ...,
     *   inputTokens: ...,
     *   iterations: ...,
     *   outputTokens: ...,
     *   outputTokensDetails: ...,
     *   serverToolUse: ...,
     *   serviceTier: ...,
     *   speed: ...,
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
     *   ->withInferenceGeo(...)
     *   ->withInputTokens(...)
     *   ->withIterations(...)
     *   ->withOutputTokens(...)
     *   ->withOutputTokensDetails(...)
     *   ->withServerToolUse(...)
     *   ->withServiceTier(...)
     *   ->withSpeed(...)
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
     * @param BetaCacheCreation|BetaCacheCreationShape|null $cacheCreation
     * @param list<BetaIterationsUsageItemShape>|null $iterations
     * @param BetaOutputTokensDetails|BetaOutputTokensDetailsShape|null $outputTokensDetails
     * @param BetaServerToolUsage|BetaServerToolUsageShape|null $serverToolUse
     * @param ServiceTier|value-of<ServiceTier>|null $serviceTier
     * @param Speed|value-of<Speed>|null $speed
     */
    public static function with(
        BetaCacheCreation|array|null $cacheCreation,
        ?int $cacheCreationInputTokens,
        ?int $cacheReadInputTokens,
        ?string $inferenceGeo,
        int $inputTokens,
        ?array $iterations,
        int $outputTokens,
        BetaOutputTokensDetails|array|null $outputTokensDetails,
        BetaServerToolUsage|array|null $serverToolUse,
        ServiceTier|string|null $serviceTier,
        Speed|string|null $speed,
    ): self {
        $self = new self;

        $self['cacheCreation'] = $cacheCreation;
        $self['cacheCreationInputTokens'] = $cacheCreationInputTokens;
        $self['cacheReadInputTokens'] = $cacheReadInputTokens;
        $self['inferenceGeo'] = $inferenceGeo;
        $self['inputTokens'] = $inputTokens;
        $self['iterations'] = $iterations;
        $self['outputTokens'] = $outputTokens;
        $self['outputTokensDetails'] = $outputTokensDetails;
        $self['serverToolUse'] = $serverToolUse;
        $self['serviceTier'] = $serviceTier;
        $self['speed'] = $speed;

        return $self;
    }

    /**
     * Breakdown of cached tokens by TTL.
     *
     * @param BetaCacheCreation|BetaCacheCreationShape|null $cacheCreation
     */
    public function withCacheCreation(
        BetaCacheCreation|array|null $cacheCreation
    ): self {
        $self = clone $this;
        $self['cacheCreation'] = $cacheCreation;

        return $self;
    }

    /**
     * The number of input tokens used to create the cache entry.
     */
    public function withCacheCreationInputTokens(
        ?int $cacheCreationInputTokens
    ): self {
        $self = clone $this;
        $self['cacheCreationInputTokens'] = $cacheCreationInputTokens;

        return $self;
    }

    /**
     * The number of input tokens read from the cache.
     */
    public function withCacheReadInputTokens(?int $cacheReadInputTokens): self
    {
        $self = clone $this;
        $self['cacheReadInputTokens'] = $cacheReadInputTokens;

        return $self;
    }

    /**
     * The geographic region where inference was performed for this request.
     */
    public function withInferenceGeo(?string $inferenceGeo): self
    {
        $self = clone $this;
        $self['inferenceGeo'] = $inferenceGeo;

        return $self;
    }

    /**
     * The number of input tokens which were used.
     */
    public function withInputTokens(int $inputTokens): self
    {
        $self = clone $this;
        $self['inputTokens'] = $inputTokens;

        return $self;
    }

    /**
     * Per-iteration token usage breakdown.
     *
     * Each entry represents one sampling iteration, with its own input/output token counts and cache statistics. This allows you to:
     * - Determine which iterations exceeded long context thresholds (>=200k tokens)
     * - Calculate the true context window size from the last iteration
     * - Understand token accumulation across server-side tool use loops
     *
     * @param list<BetaIterationsUsageItemShape>|null $iterations
     */
    public function withIterations(?array $iterations): self
    {
        $self = clone $this;
        $self['iterations'] = $iterations;

        return $self;
    }

    /**
     * The number of output tokens which were used.
     */
    public function withOutputTokens(int $outputTokens): self
    {
        $self = clone $this;
        $self['outputTokens'] = $outputTokens;

        return $self;
    }

    /**
     * Breakdown of output tokens by category.
     *
     * `output_tokens` remains the inclusive, authoritative total used for billing.
     * This object provides a read-only decomposition for observability — for example,
     * how many of the billed output tokens were spent on internal reasoning that may
     * have been summarized before being returned to you.
     *
     * @param BetaOutputTokensDetails|BetaOutputTokensDetailsShape|null $outputTokensDetails
     */
    public function withOutputTokensDetails(
        BetaOutputTokensDetails|array|null $outputTokensDetails
    ): self {
        $self = clone $this;
        $self['outputTokensDetails'] = $outputTokensDetails;

        return $self;
    }

    /**
     * The number of server tool requests.
     *
     * @param BetaServerToolUsage|BetaServerToolUsageShape|null $serverToolUse
     */
    public function withServerToolUse(
        BetaServerToolUsage|array|null $serverToolUse
    ): self {
        $self = clone $this;
        $self['serverToolUse'] = $serverToolUse;

        return $self;
    }

    /**
     * If the request used the priority, standard, or batch tier.
     *
     * @param ServiceTier|value-of<ServiceTier>|null $serviceTier
     */
    public function withServiceTier(ServiceTier|string|null $serviceTier): self
    {
        $self = clone $this;
        $self['serviceTier'] = $serviceTier;

        return $self;
    }

    /**
     * Inference speed mode. `fast` provides significantly faster output token generation at premium pricing. Not all models support `fast`; invalid combinations are rejected at create time.
     *
     * @param Speed|value-of<Speed>|null $speed
     */
    public function withSpeed(Speed|string|null $speed): self
    {
        $self = clone $this;
        $self['speed'] = $speed;

        return $self;
    }
}
