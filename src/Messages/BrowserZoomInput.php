<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Return a cropped screenshot of the given viewport region, scaled up for closer
 * inspection — useful for small icons, buttons, or text. Coordinates are in the
 * same viewport-pixel space as a full screenshot.
 *
 * @phpstan-type BrowserZoomInputShape = array{
 *   region: list<int>, tabID?: string|null
 * }
 */
final class BrowserZoomInput implements BaseModel
{
    /** @use SdkModel<BrowserZoomInputShape> */
    use SdkModel;

    /**
     * [x0, y0, x1, y1] in viewport pixels.
     *
     * @var list<int> $region
     */
    #[Required(list: 'int')]
    public array $region;

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    #[Optional('tab_id', nullable: true)]
    public ?string $tabID;

    /**
     * `new BrowserZoomInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrowserZoomInput::with(region: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrowserZoomInput())->withRegion(...)
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
    public static function with(array $region, ?string $tabID = null): self
    {
        $self = new self;

        $self['region'] = $region;

        null !== $tabID && $self['tabID'] = $tabID;

        return $self;
    }

    /**
     * [x0, y0, x1, y1] in viewport pixels.
     *
     * @param list<int> $region
     */
    public function withRegion(array $region): self
    {
        $self = clone $this;
        $self['region'] = $region;

        return $self;
    }

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    public function withTabID(?string $tabID): self
    {
        $self = clone $this;
        $self['tabID'] = $tabID;

        return $self;
    }
}
