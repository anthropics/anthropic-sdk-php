<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Click and drag the cursor from `start_coordinate` to `coordinate`.
 *
 * @phpstan-type BetaComputerLeftClickDragInputShape = array{
 *   coordinate: list<int>, startCoordinate: list<int>, text?: string|null
 * }
 */
final class BetaComputerLeftClickDragInput implements BaseModel
{
    /** @use SdkModel<BetaComputerLeftClickDragInputShape> */
    use SdkModel;

    /**
     * (x, y): x pixels from the left edge, y pixels from the top edge.
     *
     * @var list<int> $coordinate
     */
    #[Required(list: 'int')]
    public array $coordinate;

    /**
     * (x, y): x pixels from the left edge, y pixels from the top edge.
     *
     * @var list<int> $startCoordinate
     */
    #[Required('start_coordinate', list: 'int')]
    public array $startCoordinate;

    /**
     * Optional key combination to hold down during this action (e.g. "ctrl", "shift", "ctrl+shift").
     */
    #[Optional(nullable: true)]
    public ?string $text;

    /**
     * `new BetaComputerLeftClickDragInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaComputerLeftClickDragInput::with(coordinate: ..., startCoordinate: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaComputerLeftClickDragInput())
     *   ->withCoordinate(...)
     *   ->withStartCoordinate(...)
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
     * @param list<int> $coordinate
     * @param list<int> $startCoordinate
     */
    public static function with(
        array $coordinate,
        array $startCoordinate,
        ?string $text = null
    ): self {
        $self = new self;

        $self['coordinate'] = $coordinate;
        $self['startCoordinate'] = $startCoordinate;

        null !== $text && $self['text'] = $text;

        return $self;
    }

    /**
     * (x, y): x pixels from the left edge, y pixels from the top edge.
     *
     * @param list<int> $coordinate
     */
    public function withCoordinate(array $coordinate): self
    {
        $self = clone $this;
        $self['coordinate'] = $coordinate;

        return $self;
    }

    /**
     * (x, y): x pixels from the left edge, y pixels from the top edge.
     *
     * @param list<int> $startCoordinate
     */
    public function withStartCoordinate(array $startCoordinate): self
    {
        $self = clone $this;
        $self['startCoordinate'] = $startCoordinate;

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
