<?php

declare(strict_types=1);

namespace Anthropic\Beta\Models;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Model capability information.
 *
 * @phpstan-import-type BetaCapabilitySupportShape from \Anthropic\Beta\Models\BetaCapabilitySupport
 * @phpstan-import-type BetaCompactionCapabilityShape from \Anthropic\Beta\Models\BetaCompactionCapability
 * @phpstan-import-type BetaContextManagementCapabilityShape from \Anthropic\Beta\Models\BetaContextManagementCapability
 * @phpstan-import-type BetaEffortCapabilityShape from \Anthropic\Beta\Models\BetaEffortCapability
 * @phpstan-import-type BetaServerToolsCapabilityShape from \Anthropic\Beta\Models\BetaServerToolsCapability
 * @phpstan-import-type BetaThinkingCapabilityShape from \Anthropic\Beta\Models\BetaThinkingCapability
 *
 * @phpstan-type BetaModelCapabilitiesShape = array{
 *   batch: BetaCapabilitySupport|BetaCapabilitySupportShape,
 *   citations: BetaCapabilitySupport|BetaCapabilitySupportShape,
 *   codeExecution: BetaCapabilitySupport|BetaCapabilitySupportShape,
 *   compaction: null|BetaCompactionCapability|BetaCompactionCapabilityShape,
 *   contextManagement: BetaContextManagementCapability|BetaContextManagementCapabilityShape,
 *   effort: BetaEffortCapability|BetaEffortCapabilityShape,
 *   imageInput: BetaCapabilitySupport|BetaCapabilitySupportShape,
 *   pdfInput: BetaCapabilitySupport|BetaCapabilitySupportShape,
 *   serverTools: BetaServerToolsCapability|BetaServerToolsCapabilityShape,
 *   structuredOutputs: BetaCapabilitySupport|BetaCapabilitySupportShape,
 *   thinking: BetaThinkingCapability|BetaThinkingCapabilityShape,
 * }
 */
final class BetaModelCapabilities implements BaseModel
{
    /** @use SdkModel<BetaModelCapabilitiesShape> */
    use SdkModel;

    /**
     * Whether the model supports the Batch API.
     */
    #[Required]
    public BetaCapabilitySupport $batch;

    /**
     * Whether the model supports citation generation.
     */
    #[Required]
    public BetaCapabilitySupport $citations;

    /**
     * Whether code that the model runs in the code execution tool can call the request's other tools, as in programmatic tool calling and dynamic filtering for web search and web fetch. Support for the code execution tool itself is in `server_tools.code_execution`.
     */
    #[Required('code_execution')]
    public BetaCapabilitySupport $codeExecution;

    /**
     * Server-side compaction support (the top-level `compaction` parameter) and the accepted `compaction.type` values.
     */
    #[Required]
    public ?BetaCompactionCapability $compaction;

    /**
     * Context management support and available strategies.
     */
    #[Required('context_management')]
    public BetaContextManagementCapability $contextManagement;

    /**
     * Effort (reasoning_effort) support and available levels.
     */
    #[Required]
    public BetaEffortCapability $effort;

    /**
     * Whether the model accepts image content blocks.
     */
    #[Required('image_input')]
    public BetaCapabilitySupport $imageInput;

    /**
     * Whether the model accepts PDF content blocks.
     */
    #[Required('pdf_input')]
    public BetaCapabilitySupport $pdfInput;

    /**
     * Whether this model supports the web search and code execution server tools. `supported` is true when the model supports at least one of the tools. A supported tool can still be rejected for your organization, for example when an admin has turned web search off.
     */
    #[Required('server_tools')]
    public BetaServerToolsCapability $serverTools;

    /**
     * Whether the model supports structured output / JSON mode / strict tool schemas.
     */
    #[Required('structured_outputs')]
    public BetaCapabilitySupport $structuredOutputs;

    /**
     * Thinking capability and supported type configurations.
     */
    #[Required]
    public BetaThinkingCapability $thinking;

    /**
     * `new BetaModelCapabilities()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaModelCapabilities::with(
     *   batch: ...,
     *   citations: ...,
     *   codeExecution: ...,
     *   compaction: ...,
     *   contextManagement: ...,
     *   effort: ...,
     *   imageInput: ...,
     *   pdfInput: ...,
     *   serverTools: ...,
     *   structuredOutputs: ...,
     *   thinking: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaModelCapabilities())
     *   ->withBatch(...)
     *   ->withCitations(...)
     *   ->withCodeExecution(...)
     *   ->withCompaction(...)
     *   ->withContextManagement(...)
     *   ->withEffort(...)
     *   ->withImageInput(...)
     *   ->withPDFInput(...)
     *   ->withServerTools(...)
     *   ->withStructuredOutputs(...)
     *   ->withThinking(...)
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
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $batch
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $citations
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $codeExecution
     * @param BetaCompactionCapability|BetaCompactionCapabilityShape|null $compaction
     * @param BetaContextManagementCapability|BetaContextManagementCapabilityShape $contextManagement
     * @param BetaEffortCapability|BetaEffortCapabilityShape $effort
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $imageInput
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $pdfInput
     * @param BetaServerToolsCapability|BetaServerToolsCapabilityShape $serverTools
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $structuredOutputs
     * @param BetaThinkingCapability|BetaThinkingCapabilityShape $thinking
     */
    public static function with(
        BetaCapabilitySupport|array $batch,
        BetaCapabilitySupport|array $citations,
        BetaCapabilitySupport|array $codeExecution,
        BetaCompactionCapability|array|null $compaction,
        BetaContextManagementCapability|array $contextManagement,
        BetaEffortCapability|array $effort,
        BetaCapabilitySupport|array $imageInput,
        BetaCapabilitySupport|array $pdfInput,
        BetaServerToolsCapability|array $serverTools,
        BetaCapabilitySupport|array $structuredOutputs,
        BetaThinkingCapability|array $thinking,
    ): self {
        $self = new self;

        $self['batch'] = $batch;
        $self['citations'] = $citations;
        $self['codeExecution'] = $codeExecution;
        $self['compaction'] = $compaction;
        $self['contextManagement'] = $contextManagement;
        $self['effort'] = $effort;
        $self['imageInput'] = $imageInput;
        $self['pdfInput'] = $pdfInput;
        $self['serverTools'] = $serverTools;
        $self['structuredOutputs'] = $structuredOutputs;
        $self['thinking'] = $thinking;

        return $self;
    }

    /**
     * Whether the model supports the Batch API.
     *
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $batch
     */
    public function withBatch(BetaCapabilitySupport|array $batch): self
    {
        $self = clone $this;
        $self['batch'] = $batch;

        return $self;
    }

    /**
     * Whether the model supports citation generation.
     *
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $citations
     */
    public function withCitations(BetaCapabilitySupport|array $citations): self
    {
        $self = clone $this;
        $self['citations'] = $citations;

        return $self;
    }

    /**
     * Whether code that the model runs in the code execution tool can call the request's other tools, as in programmatic tool calling and dynamic filtering for web search and web fetch. Support for the code execution tool itself is in `server_tools.code_execution`.
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
     * Server-side compaction support (the top-level `compaction` parameter) and the accepted `compaction.type` values.
     *
     * @param BetaCompactionCapability|BetaCompactionCapabilityShape|null $compaction
     */
    public function withCompaction(
        BetaCompactionCapability|array|null $compaction
    ): self {
        $self = clone $this;
        $self['compaction'] = $compaction;

        return $self;
    }

    /**
     * Context management support and available strategies.
     *
     * @param BetaContextManagementCapability|BetaContextManagementCapabilityShape $contextManagement
     */
    public function withContextManagement(
        BetaContextManagementCapability|array $contextManagement
    ): self {
        $self = clone $this;
        $self['contextManagement'] = $contextManagement;

        return $self;
    }

    /**
     * Effort (reasoning_effort) support and available levels.
     *
     * @param BetaEffortCapability|BetaEffortCapabilityShape $effort
     */
    public function withEffort(BetaEffortCapability|array $effort): self
    {
        $self = clone $this;
        $self['effort'] = $effort;

        return $self;
    }

    /**
     * Whether the model accepts image content blocks.
     *
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $imageInput
     */
    public function withImageInput(
        BetaCapabilitySupport|array $imageInput
    ): self {
        $self = clone $this;
        $self['imageInput'] = $imageInput;

        return $self;
    }

    /**
     * Whether the model accepts PDF content blocks.
     *
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $pdfInput
     */
    public function withPDFInput(BetaCapabilitySupport|array $pdfInput): self
    {
        $self = clone $this;
        $self['pdfInput'] = $pdfInput;

        return $self;
    }

    /**
     * Whether this model supports the web search and code execution server tools. `supported` is true when the model supports at least one of the tools. A supported tool can still be rejected for your organization, for example when an admin has turned web search off.
     *
     * @param BetaServerToolsCapability|BetaServerToolsCapabilityShape $serverTools
     */
    public function withServerTools(
        BetaServerToolsCapability|array $serverTools
    ): self {
        $self = clone $this;
        $self['serverTools'] = $serverTools;

        return $self;
    }

    /**
     * Whether the model supports structured output / JSON mode / strict tool schemas.
     *
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $structuredOutputs
     */
    public function withStructuredOutputs(
        BetaCapabilitySupport|array $structuredOutputs
    ): self {
        $self = clone $this;
        $self['structuredOutputs'] = $structuredOutputs;

        return $self;
    }

    /**
     * Thinking capability and supported type configurations.
     *
     * @param BetaThinkingCapability|BetaThinkingCapabilityShape $thinking
     */
    public function withThinking(BetaThinkingCapability|array $thinking): self
    {
        $self = clone $this;
        $self['thinking'] = $thinking;

        return $self;
    }
}
