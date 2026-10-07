<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Take a screenshot of a rectangular region. Region coordinates are in the
 * full-screenshot space (not physical display pixels). The crop is scaled up to
 * fill the image budget so fine details become legible.
 *
 * @phpstan-type BetaComputerZoomInputShape = array{region: list<int>}
 */
final class BetaComputerZoomInput implements BaseModel
{
    /** @use SdkModel<BetaComputerZoomInputShape> */
    use SdkModel;

    /**
     * (x0, y0, x1, y1): The region to capture.
     *
     * @var list<int> $region
     */
    #[Required(list: 'int')]
    public array $region;

    /**
     * `new BetaComputerZoomInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaComputerZoomInput::with(region: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaComputerZoomInput())->withRegion(...)
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
     * @param list<int> $region
     */
    public static function with(array $region): self
    {
        $self = new self;

        $self['region'] = $region;

        return $self;
    }

    /**
     * (x0, y0, x1, y1): The region to capture.
     *
     * @param list<int> $region
     */
    public function withRegion(array $region): self
    {
        $self = clone $this;
        $self['region'] = $region;

        return $self;
    }
}
