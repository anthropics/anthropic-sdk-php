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
 * @phpstan-import-type BetaContextManagementCapabilityShape from \Anthropic\Beta\Models\BetaContextManagementCapability
 * @phpstan-import-type BetaEffortCapabilityShape from \Anthropic\Beta\Models\BetaEffortCapability
 * @phpstan-import-type BetaThinkingCapabilityShape from \Anthropic\Beta\Models\BetaThinkingCapability
 *
 * @phpstan-type BetaModelCapabilitiesShape = array{
 *   batch: BetaCapabilitySupport|BetaCapabilitySupportShape,
 *   citations: BetaCapabilitySupport|BetaCapabilitySupportShape,
 *   codeExecution: BetaCapabilitySupport|BetaCapabilitySupportShape,
 *   contextManagement: BetaContextManagementCapability|BetaContextManagementCapabilityShape,
 *   effort: BetaEffortCapability|BetaEffortCapabilityShape,
 *   imageInput: BetaCapabilitySupport|BetaCapabilitySupportShape,
 *   pdfInput: BetaCapabilitySupport|BetaCapabilitySupportShape,
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
     * Whether the model supports code execution tools.
     */
    #[Required('code_execution')]
    public BetaCapabilitySupport $codeExecution;

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
     *   contextManagement: ...,
     *   effort: ...,
     *   imageInput: ...,
     *   pdfInput: ...,
     *   structuredOutputs: ...,
     *   thinking: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaModelCapabilities)
     *   ->withBatch(...)
     *   ->withCitations(...)
     *   ->withCodeExecution(...)
     *   ->withContextManagement(...)
     *   ->withEffort(...)
     *   ->withImageInput(...)
     *   ->withPDFInput(...)
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
     * @param BetaContextManagementCapability|BetaContextManagementCapabilityShape $contextManagement
     * @param BetaEffortCapability|BetaEffortCapabilityShape $effort
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $imageInput
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $pdfInput
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $structuredOutputs
     * @param BetaThinkingCapability|BetaThinkingCapabilityShape $thinking
     */
    public static function with(
        BetaCapabilitySupport|array $batch,
        BetaCapabilitySupport|array $citations,
        BetaCapabilitySupport|array $codeExecution,
        BetaContextManagementCapability|array $contextManagement,
        BetaEffortCapability|array $effort,
        BetaCapabilitySupport|array $imageInput,
        BetaCapabilitySupport|array $pdfInput,
        BetaCapabilitySupport|array $structuredOutputs,
        BetaThinkingCapability|array $thinking,
    ): self {
        $self = new self;

        $self['batch'] = $batch;
        $self['citations'] = $citations;
        $self['codeExecution'] = $codeExecution;
        $self['contextManagement'] = $contextManagement;
        $self['effort'] = $effort;
        $self['imageInput'] = $imageInput;
        $self['pdfInput'] = $pdfInput;
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
     * Whether the model supports code execution tools.
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
