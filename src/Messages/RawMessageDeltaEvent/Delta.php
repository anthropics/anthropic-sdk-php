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
    public static function new(string $stopReason, ?string $stopSequence): self
    {
        $obj = new self;

        $obj->stopReason = $stopReason;
        $obj->stopSequence = $stopSequence;

        return $obj;
    }

    /**
     * @param StopReason::* $stopReason
     */
    public function setStopReason(string $stopReason): self
    {
        $this->stopReason = $stopReason;

        return $this;
    }

    public function setStopSequence(?string $stopSequence): self
    {
        $this->stopSequence = $stopSequence;

        return $this;
    }
}
