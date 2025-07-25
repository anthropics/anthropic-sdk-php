<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaRawMessageDeltaEvent\Delta;

/**
 * @phpstan-type beta_raw_message_delta_event_alias = array{
 *   delta: Delta, type: string, usage: BetaMessageDeltaUsage
 * }
 */
final class BetaRawMessageDeltaEvent implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'message_delta';

    #[Api]
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
    #[Api]
    public BetaMessageDeltaUsage $usage;

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
    public static function new(Delta $delta, BetaMessageDeltaUsage $usage): self
    {
        $obj = new self;

        $obj->delta = $delta;
        $obj->usage = $usage;

        return $obj;
    }

    public function setDelta(Delta $delta): self
    {
        $this->delta = $delta;

        return $this;
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
     */
    public function setUsage(BetaMessageDeltaUsage $usage): self
    {
        $this->usage = $usage;

        return $this;
    }
}
