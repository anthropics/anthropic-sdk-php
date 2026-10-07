<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Return the network requests (method, URL, status, MIME type, timing) recorded
 * since the driver attached to the tab and since the last read, one line per entry.
 * An empty result does not mean no traffic for a tab that predates attach.
 *
 * @phpstan-type BetaBrowserReadNetworkInputShape = array{tabID?: string|null}
 */
final class BetaBrowserReadNetworkInput implements BaseModel
{
    /** @use SdkModel<BetaBrowserReadNetworkInputShape> */
    use SdkModel;

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    #[Optional('tab_id', nullable: true)]
    public ?string $tabID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $tabID = null): self
    {
        $self = new self;

        null !== $tabID && $self['tabID'] = $tabID;

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
