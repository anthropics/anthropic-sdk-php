<?php

declare(strict_types=1);

namespace Anthropic\Beta\Models;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Web search and code execution tool support, with one entry per tool.
 *
 * @phpstan-import-type BetaCapabilitySupportShape from \Anthropic\Beta\Models\BetaCapabilitySupport
 *
 * @phpstan-type BetaServerToolsCapabilityShape = array{
 *   codeExecution: BetaCapabilitySupport|BetaCapabilitySupportShape,
 *   supported: bool,
 *   webSearch: BetaCapabilitySupport|BetaCapabilitySupportShape,
 * }
 */
final class BetaServerToolsCapability implements BaseModel
{
    /** @use SdkModel<BetaServerToolsCapabilityShape> */
    use SdkModel;

    /**
     * Whether the model supports the code execution tool: true when the model supports at least one version of the tool, not necessarily every version.
     */
    #[Required('code_execution')]
    public BetaCapabilitySupport $codeExecution;

    /**
     * Whether this capability is supported by the model.
     */
    #[Required]
    public bool $supported;

    /**
     * Whether the model supports the web search tool: true when the model supports at least one version of the tool, not necessarily every version.
     */
    #[Required('web_search')]
    public BetaCapabilitySupport $webSearch;

    /**
     * `new BetaServerToolsCapability()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaServerToolsCapability::with(
     *   codeExecution: ..., supported: ..., webSearch: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaServerToolsCapability())
     *   ->withCodeExecution(...)
     *   ->withSupported(...)
     *   ->withWebSearch(...)
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
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $codeExecution
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $webSearch
     */
    public static function with(
        BetaCapabilitySupport|array $codeExecution,
        bool $supported,
        BetaCapabilitySupport|array $webSearch,
    ): self {
        $self = new self;

        $self['codeExecution'] = $codeExecution;
        $self['supported'] = $supported;
        $self['webSearch'] = $webSearch;

        return $self;
    }

    /**
     * Whether the model supports the code execution tool: true when the model supports at least one version of the tool, not necessarily every version.
     *
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $codeExecution
     */
    public function withCodeExecution(
        BetaCapabilitySupport|array $codeExecution
    ): self {
        $self = clone $this;
        $self['codeExecution'] = $codeExecution;

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

    /**
     * Whether the model supports the web search tool: true when the model supports at least one version of the tool, not necessarily every version.
     *
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $webSearch
     */
    public function withWebSearch(BetaCapabilitySupport|array $webSearch): self
    {
        $self = clone $this;
        $self['webSearch'] = $webSearch;

        return $self;
    }
}
