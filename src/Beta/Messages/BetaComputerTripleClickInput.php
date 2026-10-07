<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Triple-click the left mouse button at the specified (x, y) pixel coordinate, or
 * the current cursor position if `coordinate` is omitted.
 *
 * @phpstan-type BetaComputerTripleClickInputShape = array{
 *   coordinate?: list<int>|null, text?: string|null
 * }
 */
final class BetaComputerTripleClickInput implements BaseModel
{
    /** @use SdkModel<BetaComputerTripleClickInputShape> */
    use SdkModel;

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

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<int>|null $coordinate
     */
    public static function with(
        ?array $coordinate = null,
        ?string $text = null
    ): self {
        $self = new self;

        null !== $coordinate && $self['coordinate'] = $coordinate;
        null !== $text && $self['text'] = $text;

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
