<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaRawMessageDeltaEvent\Delta;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaRawMessageDeltaEventShape = array{
 *   contextManagement: BetaContextManagementResponse|null,
 *   delta: Delta,
 *   type?: 'message_delta',
 *   usage: BetaMessageDeltaUsage,
 * }
 */
final class BetaRawMessageDeltaEvent implements BaseModel
{
    /** @use SdkModel<BetaRawMessageDeltaEventShape> */
    use SdkModel;

    /** @var 'message_delta' $type */
    #[Required]
    public string $type = 'message_delta';

    /**
     * Information about context management strategies applied during the request.
     */
    #[Required('context_management')]
    public ?BetaContextManagementResponse $contextManagement;

    #[Required]
    public Delta $delta;

    /**
     * Billing and rate-limit usage.
     *
     * Anthropic's API bills and rate-limits by token counts, as tokens represent the underlying cost to our systems.
     *
     * Under the hood, the API transforms requests into a format suitable for the model. The model's output then goes through a parsing stage before becoming an API response. As a result, the token counts in `usage` will not match one-to-one with the exact visible content of an API request or response.
     *
     * For example, `output_tokens` will be non-zero, even for an empty string response from Claude.
     *
     * Total input tokens in a request is the summation of `input_tokens`, `cache_creation_input_tokens`, and `cache_read_input_tokens`.
     */
    #[Required]
    public BetaMessageDeltaUsage $usage;

    /**
     * `new BetaRawMessageDeltaEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRawMessageDeltaEvent::with(contextManagement: ..., delta: ..., usage: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaRawMessageDeltaEvent)
     *   ->withContextManagement(...)
     *   ->withDelta(...)
     *   ->withUsage(...)
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
     * @param BetaContextManagementResponse|array{
     *   appliedEdits: list<BetaClearToolUses20250919EditResponse|BetaClearThinking20251015EditResponse>,
     * }|null $contextManagement
     * @param Delta|array{
     *   container: BetaContainer|null,
     *   stopReason: value-of<BetaStopReason>|null,
     *   stopSequence: string|null,
     * } $delta
     * @param BetaMessageDeltaUsage|array{
     *   cacheCreationInputTokens: int|null,
     *   cacheReadInputTokens: int|null,
     *   inputTokens: int|null,
     *   outputTokens: int,
     *   serverToolUse: BetaServerToolUsage|null,
     * } $usage
     */
    public static function with(
        BetaContextManagementResponse|array|null $contextManagement,
        Delta|array $delta,
        BetaMessageDeltaUsage|array $usage,
    ): self {
        $self = new self;

        $self['contextManagement'] = $contextManagement;
        $self['delta'] = $delta;
        $self['usage'] = $usage;

        return $self;
    }

    /**
     * Information about context management strategies applied during the request.
     *
     * @param BetaContextManagementResponse|array{
     *   appliedEdits: list<BetaClearToolUses20250919EditResponse|BetaClearThinking20251015EditResponse>,
     * }|null $contextManagement
     */
    public function withContextManagement(
        BetaContextManagementResponse|array|null $contextManagement
    ): self {
        $self = clone $this;
        $self['contextManagement'] = $contextManagement;

        return $self;
    }

    /**
     * @param Delta|array{
     *   container: BetaContainer|null,
     *   stopReason: value-of<BetaStopReason>|null,
     *   stopSequence: string|null,
     * } $delta
     */
    public function withDelta(Delta|array $delta): self
    {
        $self = clone $this;
        $self['delta'] = $delta;

        return $self;
    }

    /**
     * Billing and rate-limit usage.
     *
     * Anthropic's API bills and rate-limits by token counts, as tokens represent the underlying cost to our systems.
     *
     * Under the hood, the API transforms requests into a format suitable for the model. The model's output then goes through a parsing stage before becoming an API response. As a result, the token counts in `usage` will not match one-to-one with the exact visible content of an API request or response.
     *
     * For example, `output_tokens` will be non-zero, even for an empty string response from Claude.
     *
     * Total input tokens in a request is the summation of `input_tokens`, `cache_creation_input_tokens`, and `cache_read_input_tokens`.
     *
     * @param BetaMessageDeltaUsage|array{
     *   cacheCreationInputTokens: int|null,
     *   cacheReadInputTokens: int|null,
     *   inputTokens: int|null,
     *   outputTokens: int,
     *   serverToolUse: BetaServerToolUsage|null,
     * } $usage
     */
    public function withUsage(BetaMessageDeltaUsage|array $usage): self
    {
        $self = clone $this;
        $self['usage'] = $usage;

        return $self;
    }
}
