<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Model;

/**
 * Token usage for an advisor sub-inference iteration.
 *
 * @phpstan-import-type BetaCacheCreationShape from \Anthropic\Beta\Messages\BetaCacheCreation
 *
 * @phpstan-type BetaAdvisorMessageIterationUsageShape = array{
 *   cacheCreation: null|BetaCacheCreation|BetaCacheCreationShape,
 *   cacheCreationInputTokens: int,
 *   cacheReadInputTokens: int,
 *   inputTokens: int,
 *   model: string|Model|value-of<Model>,
 *   outputTokens: int,
 *   type: 'advisor_message',
 * }
 */
final class BetaAdvisorMessageIterationUsage implements BaseModel
{
    /** @use SdkModel<BetaAdvisorMessageIterationUsageShape> */
    use SdkModel;

    /**
     * Usage for an advisor sub-inference iteration.
     *
     * @var 'advisor_message' $type
     */
    #[Required]
    public string $type = 'advisor_message';

    /**
     * Breakdown of cached tokens by TTL.
     */
    #[Required('cache_creation')]
    public ?BetaCacheCreation $cacheCreation;

    /**
     * The number of input tokens used to create the cache entry.
     */
    #[Required('cache_creation_input_tokens')]
    public int $cacheCreationInputTokens;

    /**
     * The number of input tokens read from the cache.
     */
    #[Required('cache_read_input_tokens')]
    public int $cacheReadInputTokens;

    /**
     * The number of input tokens which were used.
     */
    #[Required('input_tokens')]
    public int $inputTokens;

    /**
     * The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     *
     * @var string|value-of<Model> $model
     */
    #[Required(enum: Model::class)]
    public string $model;

    /**
     * The number of output tokens which were used.
     */
    #[Required('output_tokens')]
    public int $outputTokens;

    /**
     * `new BetaAdvisorMessageIterationUsage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaAdvisorMessageIterationUsage::with(
     *   cacheCreation: ...,
     *   cacheCreationInputTokens: ...,
     *   cacheReadInputTokens: ...,
     *   inputTokens: ...,
     *   model: ...,
     *   outputTokens: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaAdvisorMessageIterationUsage)
     *   ->withCacheCreation(...)
     *   ->withCacheCreationInputTokens(...)
     *   ->withCacheReadInputTokens(...)
     *   ->withInputTokens(...)
     *   ->withModel(...)
     *   ->withOutputTokens(...)
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
     * @param string|Model|value-of<Model> $model
     */
    public static function with(
        BetaCacheCreation|array|null $cacheCreation,
        int $inputTokens,
        Model|string $model,
        int $outputTokens,
        int $cacheCreationInputTokens = 0,
        int $cacheReadInputTokens = 0,
    ): self {
        $self = new self;

        $self['cacheCreation'] = $cacheCreation;
        $self['cacheCreationInputTokens'] = $cacheCreationInputTokens;
        $self['cacheReadInputTokens'] = $cacheReadInputTokens;
        $self['inputTokens'] = $inputTokens;
        $self['model'] = $model;
        $self['outputTokens'] = $outputTokens;

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
        int $cacheCreationInputTokens
    ): self {
        $self = clone $this;
        $self['cacheCreationInputTokens'] = $cacheCreationInputTokens;

        return $self;
    }

    /**
     * The number of input tokens read from the cache.
     */
    public function withCacheReadInputTokens(int $cacheReadInputTokens): self
    {
        $self = clone $this;
        $self['cacheReadInputTokens'] = $cacheReadInputTokens;

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
     * The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     *
     * @param string|Model|value-of<Model> $model
     */
    public function withModel(Model|string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

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
     * Usage for an advisor sub-inference iteration.
     *
     * @param 'advisor_message' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
