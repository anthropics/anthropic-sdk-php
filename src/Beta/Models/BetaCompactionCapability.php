<?php

declare(strict_types=1);

namespace Anthropic\Beta\Models;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Compaction capability details: whether the model accepts the top-level
 * `compaction` request parameter, with one entry per supported
 * `compaction.type` value.
 *
 * @phpstan-import-type BetaCapabilitySupportShape from \Anthropic\Beta\Models\BetaCapabilitySupport
 *
 * @phpstan-type BetaCompactionCapabilityShape = array{
 *   summarize: BetaCapabilitySupport|BetaCapabilitySupportShape, supported: bool
 * }
 */
final class BetaCompactionCapability implements BaseModel
{
    /** @use SdkModel<BetaCompactionCapabilityShape> */
    use SdkModel;

    /**
     * Whether the summarize compaction type is supported.
     */
    #[Required]
    public BetaCapabilitySupport $summarize;

    /**
     * Whether this capability is supported by the model.
     */
    #[Required]
    public bool $supported;

    /**
     * `new BetaCompactionCapability()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCompactionCapability::with(summarize: ..., supported: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCompactionCapability)->withSummarize(...)->withSupported(...)
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
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $summarize
     */
    public static function with(
        BetaCapabilitySupport|array $summarize,
        bool $supported
    ): self {
        $self = new self;

        $self['summarize'] = $summarize;
        $self['supported'] = $supported;

        return $self;
    }

    /**
     * Whether the summarize compaction type is supported.
     *
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $summarize
     */
    public function withSummarize(BetaCapabilitySupport|array $summarize): self
    {
        $self = clone $this;
        $self['summarize'] = $summarize;

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
