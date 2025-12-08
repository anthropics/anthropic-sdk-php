<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaRawMessageDeltaEvent\Delta;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaRawMessageDeltaEventShape = array{
 *   context_management: BetaContextManagementResponse|null,
 *   delta: Delta,
 *   type: 'message_delta',
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
    #[Required]
    public ?BetaContextManagementResponse $context_management;

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
     * BetaRawMessageDeltaEvent::with(context_management: ..., delta: ..., usage: ...)
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
     *   applied_edits: list<BetaClearToolUses20250919EditResponse|BetaClearThinking20251015EditResponse>,
     * }|null $context_management
     * @param Delta|array{
     *   container: BetaContainer|null,
     *   stop_reason: value-of<BetaStopReason>|null,
     *   stop_sequence: string|null,
     * } $delta
     * @param BetaMessageDeltaUsage|array{
     *   cache_creation_input_tokens: int|null,
     *   cache_read_input_tokens: int|null,
     *   input_tokens: int|null,
     *   output_tokens: int,
     *   server_tool_use: BetaServerToolUsage|null,
     * } $usage
     */
    public static function with(
        BetaContextManagementResponse|array|null $context_management,
        Delta|array $delta,
        BetaMessageDeltaUsage|array $usage,
    ): self {
        $obj = new self;

        $obj['context_management'] = $context_management;
        $obj['delta'] = $delta;
        $obj['usage'] = $usage;

        return $obj;
    }

    /**
     * Information about context management strategies applied during the request.
     *
     * @param BetaContextManagementResponse|array{
     *   applied_edits: list<BetaClearToolUses20250919EditResponse|BetaClearThinking20251015EditResponse>,
     * }|null $contextManagement
     */
    public function withContextManagement(
        BetaContextManagementResponse|array|null $contextManagement
    ): self {
        $obj = clone $this;
        $obj['context_management'] = $contextManagement;

        return $obj;
    }

    /**
     * @param Delta|array{
     *   container: BetaContainer|null,
     *   stop_reason: value-of<BetaStopReason>|null,
     *   stop_sequence: string|null,
     * } $delta
     */
    public function withDelta(Delta|array $delta): self
    {
        $obj = clone $this;
        $obj['delta'] = $delta;

        return $obj;
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
     *   cache_creation_input_tokens: int|null,
     *   cache_read_input_tokens: int|null,
     *   input_tokens: int|null,
     *   output_tokens: int,
     *   server_tool_use: BetaServerToolUsage|null,
     * } $usage
     */
    public function withUsage(BetaMessageDeltaUsage|array $usage): self
    {
        $obj = clone $this;
        $obj['usage'] = $usage;

        return $obj;
    }
}
