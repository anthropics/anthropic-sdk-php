<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type OutputTokensDetailsShape from \Anthropic\Messages\OutputTokensDetails
 * @phpstan-import-type ServerToolUsageShape from \Anthropic\Messages\ServerToolUsage
 *
 * @phpstan-type MessageDeltaUsageShape = array{
 *   cacheCreationInputTokens: int|null,
 *   cacheReadInputTokens: int|null,
 *   inputTokens: int|null,
 *   outputTokens: int,
 *   outputTokensDetails: null|OutputTokensDetails|OutputTokensDetailsShape,
 *   serverToolUse: null|ServerToolUsage|ServerToolUsageShape,
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
     * `new MessageDeltaUsage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageDeltaUsage::with(
     *   cacheCreationInputTokens: ...,
     *   cacheReadInputTokens: ...,
     *   inputTokens: ...,
     *   outputTokens: ...,
     *   outputTokensDetails: ...,
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
     *   ->withOutputTokensDetails(...)
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
     * @param OutputTokensDetails|OutputTokensDetailsShape|null $outputTokensDetails
     * @param ServerToolUsage|ServerToolUsageShape|null $serverToolUse
     */
    public static function with(
        ?int $cacheCreationInputTokens,
        ?int $cacheReadInputTokens,
        ?int $inputTokens,
        int $outputTokens,
        OutputTokensDetails|array|null $outputTokensDetails,
        ServerToolUsage|array|null $serverToolUse,
    ): self {
        $self = new self;

        $self['cacheCreationInputTokens'] = $cacheCreationInputTokens;
        $self['cacheReadInputTokens'] = $cacheReadInputTokens;
        $self['inputTokens'] = $inputTokens;
        $self['outputTokens'] = $outputTokens;
        $self['outputTokensDetails'] = $outputTokensDetails;
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
}
