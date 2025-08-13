<?php

declare(strict_types=1);

namespace Anthropic\Messages\RawMessageDeltaEvent;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\StopReason;

/**
 * @phpstan-type delta_alias = array{
 *   stopReason: StopReason::*, stopSequence: string|null
 * }
 */
final class Delta implements BaseModel
{
    use Model;

    /** @var StopReason::* $stopReason */
    #[Api('stop_reason', enum: StopReason::class)]
    public string $stopReason;

    #[Api('stop_sequence')]
    public ?string $stopSequence;

    /**
     * `new Delta()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Delta::with(stopReason: ..., stopSequence: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Delta)->withStopReason(...)->withStopSequence(...)
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
     *
     * @param StopReason::* $stopReason
     */
    public static function with(string $stopReason, ?string $stopSequence): self
    {
        $obj = new self;

        $obj->stopReason = $stopReason;
        $obj->stopSequence = $stopSequence;

        return $obj;
    }

    /**
     * @param StopReason::* $stopReason
     */
    public function withStopReason(string $stopReason): self
    {
        $obj = clone $this;
        $obj->stopReason = $stopReason;

        return $obj;
    }

    public function withStopSequence(?string $stopSequence): self
    {
        $obj = clone $this;
        $obj->stopSequence = $stopSequence;

        return $obj;
    }
}
