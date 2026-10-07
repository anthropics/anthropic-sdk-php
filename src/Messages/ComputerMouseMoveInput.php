<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Move the cursor to a specified (x, y) pixel coordinate. Use this ONLY to hover
 * without clicking; otherwise use a click action directly.
 *
 * @phpstan-type ComputerMouseMoveInputShape = array{coordinate: list<int>}
 */
final class ComputerMouseMoveInput implements BaseModel
{
    /** @use SdkModel<ComputerMouseMoveInputShape> */
    use SdkModel;

    /**
     * (x, y): x pixels from the left edge, y pixels from the top edge.
     *
     * @var list<int> $coordinate
     */
    #[Required(list: 'int')]
    public array $coordinate;

    /**
     * `new ComputerMouseMoveInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ComputerMouseMoveInput::with(coordinate: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ComputerMouseMoveInput())->withCoordinate(...)
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
     */
    public static function with(array $coordinate): self
    {
        $self = new self;

        $self['coordinate'] = $coordinate;

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
}
