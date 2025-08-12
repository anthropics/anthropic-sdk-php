<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_message_delta_usage_alias = array{
 *   cacheCreationInputTokens: int|null,
 *   cacheReadInputTokens: int|null,
 *   inputTokens: int|null,
 *   outputTokens: int,
 *   serverToolUse: BetaServerToolUsage,
 * }
 */
final class BetaMessageDeltaUsage implements BaseModel
{
    use Model;

    /**
     * The cumulative number of input tokens used to create the cache entry.
     */
    #[Api('cache_creation_input_tokens')]
    public ?int $cacheCreationInputTokens;

    /**
     * The cumulative number of input tokens read from the cache.
     */
    #[Api('cache_read_input_tokens')]
    public ?int $cacheReadInputTokens;

    /**
     * The cumulative number of input tokens which were used.
     */
    #[Api('input_tokens')]
    public ?int $inputTokens;

    /**
     * The cumulative number of output tokens which were used.
     */
    #[Api('output_tokens')]
    public int $outputTokens;

    /**
     * The number of server tool requests.
     */
    #[Api('server_tool_use')]
    public BetaServerToolUsage $serverToolUse;

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function from(
        ?int $cacheCreationInputTokens,
        ?int $cacheReadInputTokens,
        ?int $inputTokens,
        int $outputTokens,
        BetaServerToolUsage $serverToolUse,
    ): self {
        $obj = new self;

        $obj->cacheCreationInputTokens = $cacheCreationInputTokens;
        $obj->cacheReadInputTokens = $cacheReadInputTokens;
        $obj->inputTokens = $inputTokens;
        $obj->outputTokens = $outputTokens;
        $obj->serverToolUse = $serverToolUse;

        return $obj;
    }

    /**
     * The cumulative number of input tokens used to create the cache entry.
     */
    public function setCacheCreationInputTokens(
        ?int $cacheCreationInputTokens
    ): self {
        $this->cacheCreationInputTokens = $cacheCreationInputTokens;

        return $this;
    }

    /**
     * The cumulative number of input tokens read from the cache.
     */
    public function setCacheReadInputTokens(?int $cacheReadInputTokens): self
    {
        $this->cacheReadInputTokens = $cacheReadInputTokens;

        return $this;
    }

    /**
     * The cumulative number of input tokens which were used.
     */
    public function setInputTokens(?int $inputTokens): self
    {
        $this->inputTokens = $inputTokens;

        return $this;
    }

    /**
     * The cumulative number of output tokens which were used.
     */
    public function setOutputTokens(int $outputTokens): self
    {
        $this->outputTokens = $outputTokens;

        return $this;
    }

    /**
     * The number of server tool requests.
     */
    public function setServerToolUse(BetaServerToolUsage $serverToolUse): self
    {
        $this->serverToolUse = $serverToolUse;

        return $this;
    }
}
