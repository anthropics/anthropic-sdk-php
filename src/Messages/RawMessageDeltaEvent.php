<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\RawMessageDeltaEvent\Delta;

/**
 * @phpstan-type raw_message_delta_event = array{
 *   delta: Delta, type: string, usage: MessageDeltaUsage
 * }
 */
final class RawMessageDeltaEvent implements BaseModel
{
    /** @use SdkModel<raw_message_delta_event> */
    use SdkModel;

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
    public MessageDeltaUsage $usage;

    /**
     * `new RawMessageDeltaEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RawMessageDeltaEvent::with(delta: ..., usage: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RawMessageDeltaEvent)->withDelta(...)->withUsage(...)
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
     */
    public static function with(Delta $delta, MessageDeltaUsage $usage): self
    {
        $obj = new self;

        $obj->delta = $delta;
        $obj->usage = $usage;

        return $obj;
    }

    public function withDelta(Delta $delta): self
    {
        $obj = clone $this;
        $obj->delta = $delta;

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
     */
    public function withUsage(MessageDeltaUsage $usage): self
    {
        $obj = clone $this;
        $obj->usage = $usage;

        return $obj;
    }
}
