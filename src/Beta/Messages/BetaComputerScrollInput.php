<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Scroll the screen at the specified (x, y) pixel coordinate, or the current cursor
 * position if `coordinate` is omitted. Do NOT use PageUp/PageDown to scroll.
 *
 * @phpstan-type BetaComputerScrollInputShape = array{
 *   scrollAmount: int,
 *   scrollDirection: BetaComputerScrollDirection|value-of<BetaComputerScrollDirection>,
 *   coordinate?: list<int>|null,
 *   text?: string|null,
 * }
 */
final class BetaComputerScrollInput implements BaseModel
{
    /** @use SdkModel<BetaComputerScrollInputShape> */
    use SdkModel;

    /**
     * Number of 'clicks' of the scroll wheel.
     */
    #[Required('scroll_amount')]
    public int $scrollAmount;

    /** @var value-of<BetaComputerScrollDirection> $scrollDirection */
    #[Required('scroll_direction', enum: BetaComputerScrollDirection::class)]
    public string $scrollDirection;

    /**
     * (x, y): x pixels from the left edge, y pixels from the top edge.
     *
     * @var list<int>|null $coordinate
     */
    #[Optional(list: 'int', nullable: true)]
    public ?array $coordinate;

    /**
     * Optional key combination to hold down during this action (e.g. "ctrl", "shift", "ctrl+shift").
     */
    #[Optional(nullable: true)]
    public ?string $text;

    /**
     * `new BetaComputerScrollInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaComputerScrollInput::with(scrollAmount: ..., scrollDirection: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaComputerScrollInput())->withScrollAmount(...)->withScrollDirection(...)
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
     * @param BetaComputerScrollDirection|value-of<BetaComputerScrollDirection> $scrollDirection
     * @param list<int>|null $coordinate
     */
    public static function with(
        int $scrollAmount,
        BetaComputerScrollDirection|string $scrollDirection,
        ?array $coordinate = null,
        ?string $text = null,
    ): self {
        $self = new self;

        $self['scrollAmount'] = $scrollAmount;
        $self['scrollDirection'] = $scrollDirection;

        null !== $coordinate && $self['coordinate'] = $coordinate;
        null !== $text && $self['text'] = $text;

        return $self;
    }

    /**
     * Number of 'clicks' of the scroll wheel.
     */
    public function withScrollAmount(int $scrollAmount): self
    {
        $self = clone $this;
        $self['scrollAmount'] = $scrollAmount;

        return $self;
    }

    /**
     * @param BetaComputerScrollDirection|value-of<BetaComputerScrollDirection> $scrollDirection
     */
    public function withScrollDirection(
        BetaComputerScrollDirection|string $scrollDirection
    ): self {
        $self = clone $this;
        $self['scrollDirection'] = $scrollDirection;

        return $self;
    }

    /**
     * (x, y): x pixels from the left edge, y pixels from the top edge.
     *
     * @param list<int>|null $coordinate
     */
    public function withCoordinate(?array $coordinate): self
    {
        $self = clone $this;
        $self['coordinate'] = $coordinate;

        return $self;
    }

    /**
     * Optional key combination to hold down during this action (e.g. "ctrl", "shift", "ctrl+shift").
     */
    public function withText(?string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }
}
