<?php

declare(strict_types=1);

namespace Anthropic\Messages;

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
 * @phpstan-import-type BrowserStateChangeVariants from \Anthropic\Messages\BrowserStateChange
 * @phpstan-import-type BrowserStateTabEntryShape from \Anthropic\Messages\BrowserStateTabEntry
 * @phpstan-import-type CacheControlEphemeralShape from \Anthropic\Messages\CacheControlEphemeral
 * @phpstan-import-type BrowserStateChangeShape from \Anthropic\Messages\BrowserStateChange
 *
 * @phpstan-type BrowserStateBlockParamShape = array{
 *   tabs: list<BrowserStateTabEntry|BrowserStateTabEntryShape>,
 *   type: 'browser_state',
 *   cacheControl?: null|CacheControlEphemeral|CacheControlEphemeralShape,
 *   stateChanges?: list<BrowserStateChangeShape>|null,
 * }
 */
final class BrowserStateBlockParam implements BaseModel
{
    /** @use SdkModel<BrowserStateBlockParamShape> */
    use SdkModel;

    /** @var 'browser_state' $type */
    #[Required]
    public string $type = 'browser_state';

    /**
     * All tabs open in the browser after this call — the full inventory, not a delta. May be empty. Whenever non-empty, exactly one entry carries `active: true`.
     *
     * @var list<BrowserStateTabEntry> $tabs
     */
    #[Required(list: BrowserStateTabEntry::class)]
    public array $tabs;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * Tabs opened and download state changes during this call. "Nothing to report" is expressed by omitting the field, never by an empty list.
     *
     * @var list<BrowserStateChangeVariants>|null $stateChanges
     */
    #[Optional('state_changes', list: BrowserStateChange::class, nullable: true)]
    public ?array $stateChanges;

    /**
     * `new BrowserStateBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrowserStateBlockParam::with(tabs: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrowserStateBlockParam)->withTabs(...)
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
     * @param list<BrowserStateTabEntry|BrowserStateTabEntryShape> $tabs
     * @param CacheControlEphemeral|CacheControlEphemeralShape|null $cacheControl
     * @param list<BrowserStateChangeShape>|null $stateChanges
     */
    public static function with(
        array $tabs,
        CacheControlEphemeral|array|null $cacheControl = null,
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
     * @param list<BrowserStateTabEntry|BrowserStateTabEntryShape> $tabs
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
     * @param CacheControlEphemeral|CacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        CacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * Tabs opened and download state changes during this call. "Nothing to report" is expressed by omitting the field, never by an empty list.
     *
     * @param list<BrowserStateChangeShape>|null $stateChanges
     */
    public function withStateChanges(?array $stateChanges): self
    {
        $self = clone $this;
        $self['stateChanges'] = $stateChanges;

        return $self;
    }
}
