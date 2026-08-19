<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A tab this call's execution opened that remains open at its end —
 * the creation delta of the `tabs` inventory, not an event log.
 *
 * Carries only the `tab_id`; the tab's `title` and `url` live on its
 * `tabs` entry, which must include the same `tab_id`. A tab opened
 * during a failed call gets no deferred `tab_opened`; it simply appears
 * in the next result's `tabs` inventory.
 *
 * @phpstan-type BrowserStateChangeTabOpenedShape = array{
 *   tabID: string, type: 'tab_opened'
 * }
 */
final class BrowserStateChangeTabOpened implements BaseModel
{
    /** @use SdkModel<BrowserStateChangeTabOpenedShape> */
    use SdkModel;

    /** @var 'tab_opened' $type */
    #[Required]
    public string $type = 'tab_opened';

    /**
     * The `tab_id` of the opened tab, present in `tabs`.
     */
    #[Required('tab_id')]
    public string $tabID;

    /**
     * `new BrowserStateChangeTabOpened()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrowserStateChangeTabOpened::with(tabID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrowserStateChangeTabOpened)->withTabID(...)
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
    public static function with(string $tabID): self
    {
        $self = new self;

        $self['tabID'] = $tabID;

        return $self;
    }

    /**
     * The `tab_id` of the opened tab, present in `tabs`.
     */
    public function withTabID(string $tabID): self
    {
        $self = clone $this;
        $self['tabID'] = $tabID;

        return $self;
    }

    /**
     * @param 'tab_opened' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
