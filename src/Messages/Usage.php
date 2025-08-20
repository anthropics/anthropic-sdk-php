<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Usage\ServiceTier;

/**
 * @phpstan-type usage_alias = array{
 *   cacheCreation: CacheCreation,
 *   cacheCreationInputTokens: int|null,
 *   cacheReadInputTokens: int|null,
 *   inputTokens: int,
 *   outputTokens: int,
 *   serverToolUse: ServerToolUsage,
 *   serviceTier: ServiceTier::*|null,
 * }
 */
final class Usage implements BaseModel
{
    use SdkModel;

    /**
     * Breakdown of cached tokens by TTL.
     */
    #[Api('cache_creation')]
    public CacheCreation $cacheCreation;

    /**
     * The number of input tokens used to create the cache entry.
     */
    #[Api('cache_creation_input_tokens')]
    public ?int $cacheCreationInputTokens;

    /**
     * The number of input tokens read from the cache.
     */
    #[Api('cache_read_input_tokens')]
    public ?int $cacheReadInputTokens;

    /**
     * The number of input tokens which were used.
     */
    #[Api('input_tokens')]
    public int $inputTokens;

    /**
     * The number of output tokens which were used.
     */
    #[Api('output_tokens')]
    public int $outputTokens;

    /**
     * The number of server tool requests.
     */
    #[Api('server_tool_use')]
    public ServerToolUsage $serverToolUse;

    /**
     * If the request used the priority, standard, or batch tier.
     *
     * @var ServiceTier::*|null $serviceTier
     */
    #[Api('service_tier', enum: ServiceTier::class, nullable: true)]
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
     * (new Usage)
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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param ServiceTier::*|null $serviceTier
     */
    public static function with(
        CacheCreation $cacheCreation,
        ?int $cacheCreationInputTokens,
        ?int $cacheReadInputTokens,
        int $inputTokens,
        int $outputTokens,
        ServerToolUsage $serverToolUse,
        ?string $serviceTier,
    ): self {
        $obj = new self;

        $obj->cacheCreation = $cacheCreation;
        $obj->cacheCreationInputTokens = $cacheCreationInputTokens;
        $obj->cacheReadInputTokens = $cacheReadInputTokens;
        $obj->inputTokens = $inputTokens;
        $obj->outputTokens = $outputTokens;
        $obj->serverToolUse = $serverToolUse;
        $obj->serviceTier = $serviceTier;

        return $obj;
    }

    /**
     * Breakdown of cached tokens by TTL.
     */
    public function withCacheCreation(CacheCreation $cacheCreation): self
    {
        $obj = clone $this;
        $obj->cacheCreation = $cacheCreation;

        return $obj;
    }

    /**
     * The number of input tokens used to create the cache entry.
     */
    public function withCacheCreationInputTokens(
        ?int $cacheCreationInputTokens
    ): self {
        $obj = clone $this;
        $obj->cacheCreationInputTokens = $cacheCreationInputTokens;

        return $obj;
    }

    /**
     * The number of input tokens read from the cache.
     */
    public function withCacheReadInputTokens(?int $cacheReadInputTokens): self
    {
        $obj = clone $this;
        $obj->cacheReadInputTokens = $cacheReadInputTokens;

        return $obj;
    }

    /**
     * The number of input tokens which were used.
     */
    public function withInputTokens(int $inputTokens): self
    {
        $obj = clone $this;
        $obj->inputTokens = $inputTokens;

        return $obj;
    }

    /**
     * The number of output tokens which were used.
     */
    public function withOutputTokens(int $outputTokens): self
    {
        $obj = clone $this;
        $obj->outputTokens = $outputTokens;

        return $obj;
    }

    /**
     * The number of server tool requests.
     */
    public function withServerToolUse(ServerToolUsage $serverToolUse): self
    {
        $obj = clone $this;
        $obj->serverToolUse = $serverToolUse;

        return $obj;
    }

    /**
     * If the request used the priority, standard, or batch tier.
     *
     * @param ServiceTier::*|null $serviceTier
     */
    public function withServiceTier(?string $serviceTier): self
    {
        $obj = clone $this;
        $obj->serviceTier = $serviceTier;

        return $obj;
    }
}
