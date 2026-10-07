<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A point in the browser viewport, in viewport pixels (the same frame as a
 * full-viewport screenshot).
 *
 * @phpstan-type BrowserCoordinateTargetShape = array{
 *   type: 'coordinate', x: int, y: int
 * }
 */
final class BrowserCoordinateTarget implements BaseModel
{
    /** @use SdkModel<BrowserCoordinateTargetShape> */
    use SdkModel;

    /** @var 'coordinate' $type */
    #[Required(type: new ConstantOf('coordinate'))]
    public string $type = 'coordinate';

    /**
     * Pixels from the left edge of the viewport.
     */
    #[Required]
    public int $x;

    /**
     * Pixels from the top edge of the viewport.
     */
    #[Required]
    public int $y;

    /**
     * `new BrowserCoordinateTarget()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrowserCoordinateTarget::with(x: ..., y: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrowserCoordinateTarget())->withX(...)->withY(...)
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
     */
    public static function with(int $x, int $y): self
    {
        $self = new self;

        $self['x'] = $x;
        $self['y'] = $y;

        return $self;
    }

    /**
     * @param 'coordinate' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Pixels from the left edge of the viewport.
     */
    public function withX(int $x): self
    {
        $self = clone $this;
        $self['x'] = $x;

        return $self;
    }

    /**
     * Pixels from the top edge of the viewport.
     */
    public function withY(int $y): self
    {
        $self = clone $this;
        $self['y'] = $y;

        return $self;
    }
}
