<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaRawMessageDeltaEvent\Delta;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaContextManagementResponseShape from \Anthropic\Beta\Messages\BetaContextManagementResponse
 * @phpstan-import-type DeltaShape from \Anthropic\Beta\Messages\BetaRawMessageDeltaEvent\Delta
 * @phpstan-import-type BetaMessageDeltaUsageShape from \Anthropic\Beta\Messages\BetaMessageDeltaUsage
 *
 * @phpstan-type BetaRawMessageDeltaEventShape = array{
 *   contextManagement: null|BetaContextManagementResponse|BetaContextManagementResponseShape,
 *   delta: Delta|DeltaShape,
 *   type: 'message_delta',
 *   usage: BetaMessageDeltaUsage|BetaMessageDeltaUsageShape,
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
     * @param BetaContextManagementResponseShape|null $contextManagement
     * @param DeltaShape $delta
     * @param BetaMessageDeltaUsageShape $usage
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
     * @param BetaContextManagementResponseShape|null $contextManagement
     */
    public function withContextManagement(
        BetaContextManagementResponse|array|null $contextManagement
    ): self {
        $self = clone $this;
        $self['contextManagement'] = $contextManagement;

        return $self;
    }

    /**
     * @param DeltaShape $delta
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
     * @param BetaMessageDeltaUsageShape $usage
     */
    public function withUsage(BetaMessageDeltaUsage|array $usage): self
    {
        $self = clone $this;
        $self['usage'] = $usage;

        return $self;
    }
}
