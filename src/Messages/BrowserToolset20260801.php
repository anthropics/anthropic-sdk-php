<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\BrowserToolset20260801\AllowedCaller;

/**
 * The browser toolset: a single ``tools[]`` entry (carrying no
 * ``name``) that declares the browser tool family. The model is served
 * the family's tool with any members disabled via ``configs`` removed
 * from its schema.
 *
 * @phpstan-import-type CacheControlEphemeralShape from \Anthropic\Messages\CacheControlEphemeral
 * @phpstan-import-type BrowserToolsetConfigsShape from \Anthropic\Messages\BrowserToolsetConfigs
 *
 * @phpstan-type BrowserToolset20260801Shape = array{
 *   type: 'browser_toolset_20260801',
 *   allowedCallers?: list<AllowedCaller|value-of<AllowedCaller>>|null,
 *   cacheControl?: null|CacheControlEphemeral|CacheControlEphemeralShape,
 *   configs?: null|BrowserToolsetConfigs|BrowserToolsetConfigsShape,
 * }
 */
final class BrowserToolset20260801 implements BaseModel
{
    /** @use SdkModel<BrowserToolset20260801Shape> */
    use SdkModel;

    /** @var 'browser_toolset_20260801' $type */
    #[Required]
    public string $type = 'browser_toolset_20260801';

    /** @var list<value-of<AllowedCaller>>|null $allowedCallers */
    #[Optional('allowed_callers', list: AllowedCaller::class)]
    public ?array $allowedCallers;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * Per-member configuration for ``browser_toolset_20260801``: one
     * optional field per member tool, keyed by the member name — the same
     * name the member's ``tool_use`` blocks carry. Every member is an
     * accepted key, and a member's defaults apply wherever its key is
     * absent. Unknown keys are rejected: the field set is this toolset
     * version's complete member set.
     */
    #[Optional(nullable: true)]
    public ?BrowserToolsetConfigs $configs;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<AllowedCaller|value-of<AllowedCaller>>|null $allowedCallers
     * @param CacheControlEphemeral|CacheControlEphemeralShape|null $cacheControl
     * @param BrowserToolsetConfigs|BrowserToolsetConfigsShape|null $configs
     */
    public static function with(
        ?array $allowedCallers = null,
        CacheControlEphemeral|array|null $cacheControl = null,
        BrowserToolsetConfigs|array|null $configs = null,
    ): self {
        $self = new self;

        null !== $allowedCallers && $self['allowedCallers'] = $allowedCallers;
        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
        null !== $configs && $self['configs'] = $configs;

        return $self;
    }

    /**
     * @param 'browser_toolset_20260801' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * @param list<AllowedCaller|value-of<AllowedCaller>> $allowedCallers
     */
    public function withAllowedCallers(array $allowedCallers): self
    {
        $self = clone $this;
        $self['allowedCallers'] = $allowedCallers;

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
     * Per-member configuration for ``browser_toolset_20260801``: one
     * optional field per member tool, keyed by the member name — the same
     * name the member's ``tool_use`` blocks carry. Every member is an
     * accepted key, and a member's defaults apply wherever its key is
     * absent. Unknown keys are rejected: the field set is this toolset
     * version's complete member set.
     *
     * @param BrowserToolsetConfigs|BrowserToolsetConfigsShape|null $configs
     */
    public function withConfigs(BrowserToolsetConfigs|array|null $configs): self
    {
        $self = clone $this;
        $self['configs'] = $configs;

        return $self;
    }
}
