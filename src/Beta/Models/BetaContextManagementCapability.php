<?php

declare(strict_types=1);

namespace Anthropic\Beta\Models;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Context management capability details.
 *
 * @phpstan-import-type BetaCapabilitySupportShape from \Anthropic\Beta\Models\BetaCapabilitySupport
 *
 * @phpstan-type BetaContextManagementCapabilityShape = array{
 *   clearThinking20251015: null|BetaCapabilitySupport|BetaCapabilitySupportShape,
 *   clearToolUses20250919: null|BetaCapabilitySupport|BetaCapabilitySupportShape,
 *   compact20260112: null|BetaCapabilitySupport|BetaCapabilitySupportShape,
 *   supported: bool,
 * }
 */
final class BetaContextManagementCapability implements BaseModel
{
    /** @use SdkModel<BetaContextManagementCapabilityShape> */
    use SdkModel;

    /**
     * Indicates whether a capability is supported.
     */
    #[Required('clear_thinking_20251015')]
    public ?BetaCapabilitySupport $clearThinking20251015;

    /**
     * Indicates whether a capability is supported.
     */
    #[Required('clear_tool_uses_20250919')]
    public ?BetaCapabilitySupport $clearToolUses20250919;

    /**
     * Indicates whether a capability is supported.
     */
    #[Required('compact_20260112')]
    public ?BetaCapabilitySupport $compact20260112;

    /**
     * Whether this capability is supported by the model.
     */
    #[Required]
    public bool $supported;

    /**
     * `new BetaContextManagementCapability()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaContextManagementCapability::with(
     *   clearThinking20251015: ...,
     *   clearToolUses20250919: ...,
     *   compact20260112: ...,
     *   supported: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaContextManagementCapability)
     *   ->withClearThinking20251015(...)
     *   ->withClearToolUses20250919(...)
     *   ->withCompact20260112(...)
     *   ->withSupported(...)
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
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape|null $clearThinking20251015
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape|null $clearToolUses20250919
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape|null $compact20260112
     */
    public static function with(
        BetaCapabilitySupport|array|null $clearThinking20251015,
        BetaCapabilitySupport|array|null $clearToolUses20250919,
        BetaCapabilitySupport|array|null $compact20260112,
        bool $supported,
    ): self {
        $self = new self;

        $self['clearThinking20251015'] = $clearThinking20251015;
        $self['clearToolUses20250919'] = $clearToolUses20250919;
        $self['compact20260112'] = $compact20260112;
        $self['supported'] = $supported;

        return $self;
    }

    /**
     * Indicates whether a capability is supported.
     *
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape|null $clearThinking20251015
     */
    public function withClearThinking20251015(
        BetaCapabilitySupport|array|null $clearThinking20251015
    ): self {
        $self = clone $this;
        $self['clearThinking20251015'] = $clearThinking20251015;

        return $self;
    }

    /**
     * Indicates whether a capability is supported.
     *
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape|null $clearToolUses20250919
     */
    public function withClearToolUses20250919(
        BetaCapabilitySupport|array|null $clearToolUses20250919
    ): self {
        $self = clone $this;
        $self['clearToolUses20250919'] = $clearToolUses20250919;

        return $self;
    }

    /**
     * Indicates whether a capability is supported.
     *
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape|null $compact20260112
     */
    public function withCompact20260112(
        BetaCapabilitySupport|array|null $compact20260112
    ): self {
        $self = clone $this;
        $self['compact20260112'] = $compact20260112;

        return $self;
    }

    /**
     * Whether this capability is supported by the model.
     */
    public function withSupported(bool $supported): self
    {
        $self = clone $this;
        $self['supported'] = $supported;

        return $self;
    }
}
