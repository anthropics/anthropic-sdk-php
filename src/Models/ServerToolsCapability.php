<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Web search and code execution tool support, with one entry per tool.
 *
 * @phpstan-import-type CapabilitySupportShape from \Anthropic\Models\CapabilitySupport
 *
 * @phpstan-type ServerToolsCapabilityShape = array{
 *   codeExecution: CapabilitySupport|CapabilitySupportShape,
 *   supported: bool,
 *   webSearch: CapabilitySupport|CapabilitySupportShape,
 * }
 */
final class ServerToolsCapability implements BaseModel
{
    /** @use SdkModel<ServerToolsCapabilityShape> */
    use SdkModel;

    /**
     * Whether the model supports the code execution tool: true when the model supports at least one version of the tool, not necessarily every version.
     */
    #[Required('code_execution')]
    public CapabilitySupport $codeExecution;

    /**
     * Whether this capability is supported by the model.
     */
    #[Required]
    public bool $supported;

    /**
     * Whether the model supports the web search tool: true when the model supports at least one version of the tool, not necessarily every version.
     */
    #[Required('web_search')]
    public CapabilitySupport $webSearch;

    /**
     * `new ServerToolsCapability()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ServerToolsCapability::with(codeExecution: ..., supported: ..., webSearch: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ServerToolsCapability())
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
     * @param CapabilitySupport|CapabilitySupportShape $codeExecution
     * @param CapabilitySupport|CapabilitySupportShape $webSearch
     */
    public static function with(
        CapabilitySupport|array $codeExecution,
        bool $supported,
        CapabilitySupport|array $webSearch,
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
     * @param CapabilitySupport|CapabilitySupportShape $codeExecution
     */
    public function withCodeExecution(
        CapabilitySupport|array $codeExecution
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
     * @param CapabilitySupport|CapabilitySupportShape $webSearch
     */
    public function withWebSearch(CapabilitySupport|array $webSearch): self
    {
        $self = clone $this;
        $self['webSearch'] = $webSearch;

        return $self;
    }
}
