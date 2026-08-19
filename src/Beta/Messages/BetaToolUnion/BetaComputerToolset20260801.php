<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaToolUnion;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral;
use Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\AllowedCaller;
use Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The computer toolset: a single ``tools[]`` entry (carrying no
 * ``name``) that declares the computer tool family. The model is
 * served the family's tool with any members disabled via ``configs``
 * removed from its schema. Every member is enabled by default, zoom
 * included. The single-tool options ``display_number`` and
 * ``enable_zoom`` are not fields of a toolset entry — it carries only
 * ``type``, ``configs``, and ``cache_control``; zoom is controlled
 * via ``configs.zoom.enabled``.
 *
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 * @phpstan-import-type ConfigsShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs
 *
 * @phpstan-type BetaComputerToolset20260801Shape = array{
 *   type: 'computer_toolset_20260801',
 *   allowedCallers?: list<AllowedCaller|value-of<AllowedCaller>>|null,
 *   cacheControl?: null|BetaCacheControlEphemeral|BetaCacheControlEphemeralShape,
 *   configs?: null|Configs|ConfigsShape,
 * }
 */
final class BetaComputerToolset20260801 implements BaseModel
{
    /** @use SdkModel<BetaComputerToolset20260801Shape> */
    use SdkModel;

    /** @var 'computer_toolset_20260801' $type */
    #[Required]
    public string $type = 'computer_toolset_20260801';

    /** @var list<value-of<AllowedCaller>>|null $allowedCallers */
    #[Optional('allowed_callers', list: AllowedCaller::class)]
    public ?array $allowedCallers;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * Per-member configuration for ``computer_toolset_20260801``: one
     * optional field per member tool, keyed by the member name — the same
     * name the member's ``tool_use`` blocks carry. Every member is an
     * accepted key, and a member's defaults apply wherever its key is
     * absent. Unknown keys are rejected: the field set is this toolset
     * version's complete member set.
     */
    #[Optional(nullable: true)]
    public ?Configs $configs;

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
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl
     * @param Configs|ConfigsShape|null $configs
     */
    public static function with(
        ?array $allowedCallers = null,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        Configs|array|null $configs = null,
    ): self {
        $self = new self;

        null !== $allowedCallers && $self['allowedCallers'] = $allowedCallers;
        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
        null !== $configs && $self['configs'] = $configs;

        return $self;
    }

    /**
     * @param 'computer_toolset_20260801' $type
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
     * Per-member configuration for ``computer_toolset_20260801``: one
     * optional field per member tool, keyed by the member name — the same
     * name the member's ``tool_use`` blocks carry. Every member is an
     * accepted key, and a member's defaults apply wherever its key is
     * absent. Unknown keys are rejected: the field set is this toolset
     * version's complete member set.
     *
     * @param Configs|ConfigsShape|null $configs
     */
    public function withConfigs(Configs|array|null $configs): self
    {
        $self = clone $this;
        $self['configs'] = $configs;

        return $self;
    }
}
