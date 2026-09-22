<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A tool defined by value, as a `compaction` block's `tool_changes` entry
 * reports it: `definition` is the tool's definition as it was sent, in the
 * form of a `tools` entry, without `cache_control`. Send it back unchanged
 * with the block.
 *
 * @phpstan-import-type BetaResponseToolUnionVariants from \Anthropic\Beta\Messages\BetaResponseToolUnion
 * @phpstan-import-type BetaResponseToolUnionShape from \Anthropic\Beta\Messages\BetaResponseToolUnion
 *
 * @phpstan-type BetaToolChangeToolDefinitionShape = array{
 *   definition: BetaResponseToolUnionShape, type: 'tool_definition'
 * }
 */
final class BetaToolChangeToolDefinition implements BaseModel
{
    /** @use SdkModel<BetaToolChangeToolDefinitionShape> */
    use SdkModel;

    /** @var 'tool_definition' $type */
    #[Required(type: new ConstantOf('tool_definition'))]
    public string $type = 'tool_definition';

    /** @var BetaResponseToolUnionVariants $definition */
    #[Required]
    public BetaResponseTool|BetaToolBash20241022|BetaToolBash20250124|BetaCodeExecutionTool20250522|BetaCodeExecutionTool20250825|BetaCodeExecutionTool20260120|BetaCodeExecutionTool20260521|BetaBrowserToolset20260801|BetaToolComputerUse20241022|BetaMemoryTool20250818|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolComputerUse20251124|BetaComputerToolset20260801|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaToolTextEditor20250728|BetaWebSearchTool20250305|BetaWebFetchTool20250910|BetaWebSearchTool20260209|BetaWebFetchTool20260209|BetaWebFetchTool20260309|BetaWebSearchTool20260318|BetaWebFetchTool20260318|BetaAdvisorTool20260301|BetaToolSearchToolBm25_20251119|BetaToolSearchToolRegex20251119|BetaMCPToolset $definition;

    /**
     * `new BetaToolChangeToolDefinition()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolChangeToolDefinition::with(definition: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolChangeToolDefinition)->withDefinition(...)
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
     * @param BetaResponseToolUnionShape $definition
     */
    public static function with(
        BetaResponseTool|array|BetaToolBash20241022|BetaToolBash20250124|BetaCodeExecutionTool20250522|BetaCodeExecutionTool20250825|BetaCodeExecutionTool20260120|BetaCodeExecutionTool20260521|BetaBrowserToolset20260801|BetaToolComputerUse20241022|BetaMemoryTool20250818|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolComputerUse20251124|BetaComputerToolset20260801|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaToolTextEditor20250728|BetaWebSearchTool20250305|BetaWebFetchTool20250910|BetaWebSearchTool20260209|BetaWebFetchTool20260209|BetaWebFetchTool20260309|BetaWebSearchTool20260318|BetaWebFetchTool20260318|BetaAdvisorTool20260301|BetaToolSearchToolBm25_20251119|BetaToolSearchToolRegex20251119|BetaMCPToolset $definition,
    ): self {
        $self = new self;

        $self['definition'] = $definition;

        return $self;
    }

    /**
     * @param BetaResponseToolUnionShape $definition
     */
    public function withDefinition(
        BetaResponseTool|array|BetaToolBash20241022|BetaToolBash20250124|BetaCodeExecutionTool20250522|BetaCodeExecutionTool20250825|BetaCodeExecutionTool20260120|BetaCodeExecutionTool20260521|BetaBrowserToolset20260801|BetaToolComputerUse20241022|BetaMemoryTool20250818|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolComputerUse20251124|BetaComputerToolset20260801|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaToolTextEditor20250728|BetaWebSearchTool20250305|BetaWebFetchTool20250910|BetaWebSearchTool20260209|BetaWebFetchTool20260209|BetaWebFetchTool20260309|BetaWebSearchTool20260318|BetaWebFetchTool20260318|BetaAdvisorTool20260301|BetaToolSearchToolBm25_20251119|BetaToolSearchToolRegex20251119|BetaMCPToolset $definition,
    ): self {
        $self = clone $this;
        $self['definition'] = $definition;

        return $self;
    }

    /**
     * @param 'tool_definition' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
