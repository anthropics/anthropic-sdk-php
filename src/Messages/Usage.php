<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Usage\ServiceTier;

/**
 * @phpstan-type usage_alias = array{
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
    use ModelTrait;

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
     * @var null|ServiceTier::* $serviceTier
     */
    #[Api('service_tier', enum: ServiceTier::class, nullable: true)]
    public ?string $serviceTier;

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
     * @param null|ServiceTier::* $serviceTier
     */
    public static function from(
        ?int $cacheCreationInputTokens,
        ?int $cacheReadInputTokens,
        int $inputTokens,
        int $outputTokens,
        ServerToolUsage $serverToolUse,
        ?string $serviceTier,
    ): self {
        $obj = new self;

        $obj->cacheCreationInputTokens = $cacheCreationInputTokens;
        $obj->cacheReadInputTokens = $cacheReadInputTokens;
        $obj->inputTokens = $inputTokens;
        $obj->outputTokens = $outputTokens;
        $obj->serverToolUse = $serverToolUse;
        $obj->serviceTier = $serviceTier;

        return $obj;
    }

    /**
     * The number of input tokens used to create the cache entry.
     */
    public function setCacheCreationInputTokens(
        ?int $cacheCreationInputTokens
    ): self {
        $this->cacheCreationInputTokens = $cacheCreationInputTokens;

        return $this;
    }

    /**
     * The number of input tokens read from the cache.
     */
    public function setCacheReadInputTokens(?int $cacheReadInputTokens): self
    {
        $this->cacheReadInputTokens = $cacheReadInputTokens;

        return $this;
    }

    /**
     * The number of input tokens which were used.
     */
    public function setInputTokens(int $inputTokens): self
    {
        $this->inputTokens = $inputTokens;

        return $this;
    }

    /**
     * The number of output tokens which were used.
     */
    public function setOutputTokens(int $outputTokens): self
    {
        $this->outputTokens = $outputTokens;

        return $this;
    }

    /**
     * The number of server tool requests.
     */
    public function setServerToolUse(ServerToolUsage $serverToolUse): self
    {
        $this->serverToolUse = $serverToolUse;

        return $this;
    }

    /**
     * If the request used the priority, standard, or batch tier.
     *
     * @param null|ServiceTier::* $serviceTier
     */
    public function setServiceTier(?string $serviceTier): self
    {
        $this->serviceTier = $serviceTier;

        return $this;
    }
}
