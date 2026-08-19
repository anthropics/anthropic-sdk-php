<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaToolResultBlockParam\Content\Content;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral;
use Anthropic\Beta\Messages\BetaToolResultBlockParam\Content\Content\BetaRequestBrowserStateBlock\StateChange;
use Anthropic\Beta\Messages\BetaToolResultBlockParam\Content\Content\BetaRequestBrowserStateBlock\Tab;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The caller's browser state after a browser toolset member call —
 * the full inventory of open tabs, which tab is active, and any side
 * effects (tabs opened, download state changes) the call produced.
 *
 * At most one per `tool_result`, only on a non-error result answering a
 * browser toolset member `tool_use`. The server renders the
 * model-visible text from it; the model never sees the raw fields.
 *
 * @phpstan-import-type StateChangeVariants from \Anthropic\Beta\Messages\BetaToolResultBlockParam\Content\Content\BetaRequestBrowserStateBlock\StateChange
 * @phpstan-import-type TabShape from \Anthropic\Beta\Messages\BetaToolResultBlockParam\Content\Content\BetaRequestBrowserStateBlock\Tab
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 * @phpstan-import-type StateChangeShape from \Anthropic\Beta\Messages\BetaToolResultBlockParam\Content\Content\BetaRequestBrowserStateBlock\StateChange
 *
 * @phpstan-type BetaRequestBrowserStateBlockShape = array{
 *   tabs: list<Tab|TabShape>,
 *   type: 'browser_state',
 *   cacheControl?: null|BetaCacheControlEphemeral|BetaCacheControlEphemeralShape,
 *   stateChanges?: list<StateChangeShape>|null,
 * }
 */
final class BetaRequestBrowserStateBlock implements BaseModel
{
    /** @use SdkModel<BetaRequestBrowserStateBlockShape> */
    use SdkModel;

    /** @var 'browser_state' $type */
    #[Required]
    public string $type = 'browser_state';

    /**
     * All tabs open in the browser after this call — the full inventory, not a delta. May be empty. Whenever non-empty, exactly one entry carries `active: true`.
     *
     * @var list<Tab> $tabs
     */
    #[Required(list: Tab::class)]
    public array $tabs;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * Tabs opened and download state changes during this call. "Nothing to report" is expressed by omitting the field, never by an empty list.
     *
     * @var list<StateChangeVariants>|null $stateChanges
     */
    #[Optional('state_changes', list: StateChange::class, nullable: true)]
    public ?array $stateChanges;

    /**
     * `new BetaRequestBrowserStateBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRequestBrowserStateBlock::with(tabs: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaRequestBrowserStateBlock)->withTabs(...)
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
     * @param list<Tab|TabShape> $tabs
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl
     * @param list<StateChangeShape>|null $stateChanges
     */
    public static function with(
        array $tabs,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        ?array $stateChanges = null,
    ): self {
        $self = new self;

        $self['tabs'] = $tabs;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
        null !== $stateChanges && $self['stateChanges'] = $stateChanges;

        return $self;
    }

    /**
     * All tabs open in the browser after this call — the full inventory, not a delta. May be empty. Whenever non-empty, exactly one entry carries `active: true`.
     *
     * @param list<Tab|TabShape> $tabs
     */
    public function withTabs(array $tabs): self
    {
        $self = clone $this;
        $self['tabs'] = $tabs;

        return $self;
    }

    /**
     * @param 'browser_state' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * Tabs opened and download state changes during this call. "Nothing to report" is expressed by omitting the field, never by an empty list.
     *
     * @param list<StateChangeShape>|null $stateChanges
     */
    public function withStateChanges(?array $stateChanges): self
    {
        $self = clone $this;
        $self['stateChanges'] = $stateChanges;

        return $self;
    }
}
