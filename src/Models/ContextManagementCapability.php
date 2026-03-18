<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Context management capability details.
 *
 * @phpstan-import-type CapabilitySupportShape from \Anthropic\Models\CapabilitySupport
 *
 * @phpstan-type ContextManagementCapabilityShape = array{
 *   clearThinking20251015: null|CapabilitySupport|CapabilitySupportShape,
 *   clearToolUses20250919: null|CapabilitySupport|CapabilitySupportShape,
 *   compact20260112: null|CapabilitySupport|CapabilitySupportShape,
 *   supported: bool,
 * }
 */
final class ContextManagementCapability implements BaseModel
{
    /** @use SdkModel<ContextManagementCapabilityShape> */
    use SdkModel;

    /**
     * Indicates whether a capability is supported.
     */
    #[Required('clear_thinking_20251015')]
    public ?CapabilitySupport $clearThinking20251015;

    /**
     * Indicates whether a capability is supported.
     */
    #[Required('clear_tool_uses_20250919')]
    public ?CapabilitySupport $clearToolUses20250919;

    /**
     * Indicates whether a capability is supported.
     */
    #[Required('compact_20260112')]
    public ?CapabilitySupport $compact20260112;

    /**
     * Whether this capability is supported by the model.
     */
    #[Required]
    public bool $supported;

    /**
     * `new ContextManagementCapability()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ContextManagementCapability::with(
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
     * (new ContextManagementCapability)
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
     * @param CapabilitySupport|CapabilitySupportShape|null $clearThinking20251015
     * @param CapabilitySupport|CapabilitySupportShape|null $clearToolUses20250919
     * @param CapabilitySupport|CapabilitySupportShape|null $compact20260112
     */
    public static function with(
        CapabilitySupport|array|null $clearThinking20251015,
        CapabilitySupport|array|null $clearToolUses20250919,
        CapabilitySupport|array|null $compact20260112,
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
     * @param CapabilitySupport|CapabilitySupportShape|null $clearThinking20251015
     */
    public function withClearThinking20251015(
        CapabilitySupport|array|null $clearThinking20251015
    ): self {
        $self = clone $this;
        $self['clearThinking20251015'] = $clearThinking20251015;

        return $self;
    }

    /**
     * Indicates whether a capability is supported.
     *
     * @param CapabilitySupport|CapabilitySupportShape|null $clearToolUses20250919
     */
    public function withClearToolUses20250919(
        CapabilitySupport|array|null $clearToolUses20250919
    ): self {
        $self = clone $this;
        $self['clearToolUses20250919'] = $clearToolUses20250919;

        return $self;
    }

    /**
     * Indicates whether a capability is supported.
     *
     * @param CapabilitySupport|CapabilitySupportShape|null $compact20260112
     */
    public function withCompact20260112(
        CapabilitySupport|array|null $compact20260112
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
