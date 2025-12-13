<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type MessageDeltaUsageShape = array{
 *   cacheCreationInputTokens: int|null,
 *   cacheReadInputTokens: int|null,
 *   inputTokens: int|null,
 *   outputTokens: int,
 *   serverToolUse: ServerToolUsage|null,
 * }
 */
final class MessageDeltaUsage implements BaseModel
{
    /** @use SdkModel<MessageDeltaUsageShape> */
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
    public ?ServerToolUsage $serverToolUse;

    /**
     * `new MessageDeltaUsage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageDeltaUsage::with(
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
     * (new MessageDeltaUsage)
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
     * @param ServerToolUsage|array{webSearchRequests: int}|null $serverToolUse
     */
    public static function with(
        ?int $cacheCreationInputTokens,
        ?int $cacheReadInputTokens,
        ?int $inputTokens,
        int $outputTokens,
        ServerToolUsage|array|null $serverToolUse,
    ): self {
        $self = new self;

        $self['cacheCreationInputTokens'] = $cacheCreationInputTokens;
        $self['cacheReadInputTokens'] = $cacheReadInputTokens;
        $self['inputTokens'] = $inputTokens;
        $self['outputTokens'] = $outputTokens;
        $self['serverToolUse'] = $serverToolUse;

        return $self;
    }

    /**
     * The cumulative number of input tokens used to create the cache entry.
     */
    public function withCacheCreationInputTokens(
        ?int $cacheCreationInputTokens
    ): self {
        $self = clone $this;
        $self['cacheCreationInputTokens'] = $cacheCreationInputTokens;

        return $self;
    }

    /**
     * The cumulative number of input tokens read from the cache.
     */
    public function withCacheReadInputTokens(?int $cacheReadInputTokens): self
    {
        $self = clone $this;
        $self['cacheReadInputTokens'] = $cacheReadInputTokens;

        return $self;
    }

    /**
     * The cumulative number of input tokens which were used.
     */
    public function withInputTokens(?int $inputTokens): self
    {
        $self = clone $this;
        $self['inputTokens'] = $inputTokens;

        return $self;
    }

    /**
     * The cumulative number of output tokens which were used.
     */
    public function withOutputTokens(int $outputTokens): self
    {
        $self = clone $this;
        $self['outputTokens'] = $outputTokens;

        return $self;
    }

    /**
     * The number of server tool requests.
     *
     * @param ServerToolUsage|array{webSearchRequests: int}|null $serverToolUse
     */
    public function withServerToolUse(
        ServerToolUsage|array|null $serverToolUse
    ): self {
        $self = clone $this;
        $self['serverToolUse'] = $serverToolUse;

        return $self;
    }
}
