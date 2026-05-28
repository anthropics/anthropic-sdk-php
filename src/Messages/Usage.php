<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Usage\ServiceTier;

/**
 * @phpstan-import-type CacheCreationShape from \Anthropic\Messages\CacheCreation
 * @phpstan-import-type OutputTokensDetailsShape from \Anthropic\Messages\OutputTokensDetails
 * @phpstan-import-type ServerToolUsageShape from \Anthropic\Messages\ServerToolUsage
 *
 * @phpstan-type UsageShape = array{
 *   cacheCreation: null|CacheCreation|CacheCreationShape,
 *   cacheCreationInputTokens: int|null,
 *   cacheReadInputTokens: int|null,
 *   inferenceGeo: string|null,
 *   inputTokens: int,
 *   outputTokens: int,
 *   outputTokensDetails: null|OutputTokensDetails|OutputTokensDetailsShape,
 *   serverToolUse: null|ServerToolUsage|ServerToolUsageShape,
 *   serviceTier: null|ServiceTier|value-of<ServiceTier>,
 * }
 */
final class Usage implements BaseModel
{
    /** @use SdkModel<UsageShape> */
    use SdkModel;

    /**
     * Breakdown of cached tokens by TTL.
     */
    #[Required('cache_creation')]
    public ?CacheCreation $cacheCreation;

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
    public ?OutputTokensDetails $outputTokensDetails;

    /**
     * The number of server tool requests.
     */
    #[Required('server_tool_use')]
    public ?ServerToolUsage $serverToolUse;

    /**
     * If the request used the priority, standard, or batch tier.
     *
     * @var value-of<ServiceTier>|null $serviceTier
     */
    #[Required('service_tier', enum: ServiceTier::class)]
    public ?string $serviceTier;

    /**
     * `new Usage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Usage::with(
     *   cacheCreation: ...,
     *   cacheCreationInputTokens: ...,
     *   cacheReadInputTokens: ...,
     *   inferenceGeo: ...,
     *   inputTokens: ...,
     *   outputTokens: ...,
     *   outputTokensDetails: ...,
     *   serverToolUse: ...,
     *   serviceTier: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Usage)
     *   ->withCacheCreation(...)
     *   ->withCacheCreationInputTokens(...)
     *   ->withCacheReadInputTokens(...)
     *   ->withInferenceGeo(...)
     *   ->withInputTokens(...)
     *   ->withOutputTokens(...)
     *   ->withOutputTokensDetails(...)
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
     * @param CacheCreation|CacheCreationShape|null $cacheCreation
     * @param OutputTokensDetails|OutputTokensDetailsShape|null $outputTokensDetails
     * @param ServerToolUsage|ServerToolUsageShape|null $serverToolUse
     * @param ServiceTier|value-of<ServiceTier>|null $serviceTier
     */
    public static function with(
        CacheCreation|array|null $cacheCreation,
        ?int $cacheCreationInputTokens,
        ?int $cacheReadInputTokens,
        ?string $inferenceGeo,
        int $inputTokens,
        int $outputTokens,
        OutputTokensDetails|array|null $outputTokensDetails,
        ServerToolUsage|array|null $serverToolUse,
        ServiceTier|string|null $serviceTier,
    ): self {
        $self = new self;

        $self['cacheCreation'] = $cacheCreation;
        $self['cacheCreationInputTokens'] = $cacheCreationInputTokens;
        $self['cacheReadInputTokens'] = $cacheReadInputTokens;
        $self['inferenceGeo'] = $inferenceGeo;
        $self['inputTokens'] = $inputTokens;
        $self['outputTokens'] = $outputTokens;
        $self['outputTokensDetails'] = $outputTokensDetails;
        $self['serverToolUse'] = $serverToolUse;
        $self['serviceTier'] = $serviceTier;

        return $self;
    }

    /**
     * Breakdown of cached tokens by TTL.
     *
     * @param CacheCreation|CacheCreationShape|null $cacheCreation
     */
    public function withCacheCreation(
        CacheCreation|array|null $cacheCreation
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
     * @param OutputTokensDetails|OutputTokensDetailsShape|null $outputTokensDetails
     */
    public function withOutputTokensDetails(
        OutputTokensDetails|array|null $outputTokensDetails
    ): self {
        $self = clone $this;
        $self['outputTokensDetails'] = $outputTokensDetails;

        return $self;
    }

    /**
     * The number of server tool requests.
     *
     * @param ServerToolUsage|ServerToolUsageShape|null $serverToolUse
     */
    public function withServerToolUse(
        ServerToolUsage|array|null $serverToolUse
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
}
