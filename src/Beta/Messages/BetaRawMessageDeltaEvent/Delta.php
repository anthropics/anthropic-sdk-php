<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaRawMessageDeltaEvent;

use Anthropic\Beta\Messages\BetaContainer;
use Anthropic\Beta\Messages\BetaSkill;
use Anthropic\Beta\Messages\BetaStopReason;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type DeltaShape = array{
 *   container: BetaContainer|null,
 *   stopReason: value-of<BetaStopReason>|null,
 *   stopSequence: string|null,
 * }
 */
final class Delta implements BaseModel
{
    /** @use SdkModel<DeltaShape> */
    use SdkModel;

    /**
     * Information about the container used in the request (for the code execution tool).
     */
    #[Required]
    public ?BetaContainer $container;

    /** @var value-of<BetaStopReason>|null $stopReason */
    #[Required('stop_reason', enum: BetaStopReason::class)]
    public ?string $stopReason;

    #[Required('stop_sequence')]
    public ?string $stopSequence;

    /**
     * `new Delta()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Delta::with(container: ..., stopReason: ..., stopSequence: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Delta)->withContainer(...)->withStopReason(...)->withStopSequence(...)
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
     * @param BetaContainer|array{
     *   id: string, expiresAt: \DateTimeInterface, skills: list<BetaSkill>|null
     * }|null $container
     * @param BetaStopReason|value-of<BetaStopReason>|null $stopReason
     */
    public static function with(
        BetaContainer|array|null $container,
        BetaStopReason|string|null $stopReason,
        ?string $stopSequence,
    ): self {
        $self = new self;

        $self['container'] = $container;
        $self['stopReason'] = $stopReason;
        $self['stopSequence'] = $stopSequence;

        return $self;
    }

    /**
     * Information about the container used in the request (for the code execution tool).
     *
     * @param BetaContainer|array{
     *   id: string, expiresAt: \DateTimeInterface, skills: list<BetaSkill>|null
     * }|null $container
     */
    public function withContainer(BetaContainer|array|null $container): self
    {
        $self = clone $this;
        $self['container'] = $container;

        return $self;
    }

    /**
     * @param BetaStopReason|value-of<BetaStopReason>|null $stopReason
     */
    public function withStopReason(BetaStopReason|string|null $stopReason): self
    {
        $self = clone $this;
        $self['stopReason'] = $stopReason;

        return $self;
    }

    public function withStopSequence(?string $stopSequence): self
    {
        $self = clone $this;
        $self['stopSequence'] = $stopSequence;

        return $self;
    }
}
