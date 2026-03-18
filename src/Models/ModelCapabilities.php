<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Model capability information.
 *
 * @phpstan-import-type CapabilitySupportShape from \Anthropic\Models\CapabilitySupport
 * @phpstan-import-type ContextManagementCapabilityShape from \Anthropic\Models\ContextManagementCapability
 * @phpstan-import-type EffortCapabilityShape from \Anthropic\Models\EffortCapability
 * @phpstan-import-type ThinkingCapabilityShape from \Anthropic\Models\ThinkingCapability
 *
 * @phpstan-type ModelCapabilitiesShape = array{
 *   batch: CapabilitySupport|CapabilitySupportShape,
 *   citations: CapabilitySupport|CapabilitySupportShape,
 *   codeExecution: CapabilitySupport|CapabilitySupportShape,
 *   contextManagement: ContextManagementCapability|ContextManagementCapabilityShape,
 *   effort: EffortCapability|EffortCapabilityShape,
 *   imageInput: CapabilitySupport|CapabilitySupportShape,
 *   pdfInput: CapabilitySupport|CapabilitySupportShape,
 *   structuredOutputs: CapabilitySupport|CapabilitySupportShape,
 *   thinking: ThinkingCapability|ThinkingCapabilityShape,
 * }
 */
final class ModelCapabilities implements BaseModel
{
    /** @use SdkModel<ModelCapabilitiesShape> */
    use SdkModel;

    /**
     * Whether the model supports the Batch API.
     */
    #[Required]
    public CapabilitySupport $batch;

    /**
     * Whether the model supports citation generation.
     */
    #[Required]
    public CapabilitySupport $citations;

    /**
     * Whether the model supports code execution tools.
     */
    #[Required('code_execution')]
    public CapabilitySupport $codeExecution;

    /**
     * Context management support and available strategies.
     */
    #[Required('context_management')]
    public ContextManagementCapability $contextManagement;

    /**
     * Effort (reasoning_effort) support and available levels.
     */
    #[Required]
    public EffortCapability $effort;

    /**
     * Whether the model accepts image content blocks.
     */
    #[Required('image_input')]
    public CapabilitySupport $imageInput;

    /**
     * Whether the model accepts PDF content blocks.
     */
    #[Required('pdf_input')]
    public CapabilitySupport $pdfInput;

    /**
     * Whether the model supports structured output / JSON mode / strict tool schemas.
     */
    #[Required('structured_outputs')]
    public CapabilitySupport $structuredOutputs;

    /**
     * Thinking capability and supported type configurations.
     */
    #[Required]
    public ThinkingCapability $thinking;

    /**
     * `new ModelCapabilities()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ModelCapabilities::with(
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
     * (new ModelCapabilities)
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
     * @param CapabilitySupport|CapabilitySupportShape $batch
     * @param CapabilitySupport|CapabilitySupportShape $citations
     * @param CapabilitySupport|CapabilitySupportShape $codeExecution
     * @param ContextManagementCapability|ContextManagementCapabilityShape $contextManagement
     * @param EffortCapability|EffortCapabilityShape $effort
     * @param CapabilitySupport|CapabilitySupportShape $imageInput
     * @param CapabilitySupport|CapabilitySupportShape $pdfInput
     * @param CapabilitySupport|CapabilitySupportShape $structuredOutputs
     * @param ThinkingCapability|ThinkingCapabilityShape $thinking
     */
    public static function with(
        CapabilitySupport|array $batch,
        CapabilitySupport|array $citations,
        CapabilitySupport|array $codeExecution,
        ContextManagementCapability|array $contextManagement,
        EffortCapability|array $effort,
        CapabilitySupport|array $imageInput,
        CapabilitySupport|array $pdfInput,
        CapabilitySupport|array $structuredOutputs,
        ThinkingCapability|array $thinking,
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
     * @param CapabilitySupport|CapabilitySupportShape $batch
     */
    public function withBatch(CapabilitySupport|array $batch): self
    {
        $self = clone $this;
        $self['batch'] = $batch;

        return $self;
    }

    /**
     * Whether the model supports citation generation.
     *
     * @param CapabilitySupport|CapabilitySupportShape $citations
     */
    public function withCitations(CapabilitySupport|array $citations): self
    {
        $self = clone $this;
        $self['citations'] = $citations;

        return $self;
    }

    /**
     * Whether the model supports code execution tools.
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
     * Context management support and available strategies.
     *
     * @param ContextManagementCapability|ContextManagementCapabilityShape $contextManagement
     */
    public function withContextManagement(
        ContextManagementCapability|array $contextManagement
    ): self {
        $self = clone $this;
        $self['contextManagement'] = $contextManagement;

        return $self;
    }

    /**
     * Effort (reasoning_effort) support and available levels.
     *
     * @param EffortCapability|EffortCapabilityShape $effort
     */
    public function withEffort(EffortCapability|array $effort): self
    {
        $self = clone $this;
        $self['effort'] = $effort;

        return $self;
    }

    /**
     * Whether the model accepts image content blocks.
     *
     * @param CapabilitySupport|CapabilitySupportShape $imageInput
     */
    public function withImageInput(CapabilitySupport|array $imageInput): self
    {
        $self = clone $this;
        $self['imageInput'] = $imageInput;

        return $self;
    }

    /**
     * Whether the model accepts PDF content blocks.
     *
     * @param CapabilitySupport|CapabilitySupportShape $pdfInput
     */
    public function withPDFInput(CapabilitySupport|array $pdfInput): self
    {
        $self = clone $this;
        $self['pdfInput'] = $pdfInput;

        return $self;
    }

    /**
     * Whether the model supports structured output / JSON mode / strict tool schemas.
     *
     * @param CapabilitySupport|CapabilitySupportShape $structuredOutputs
     */
    public function withStructuredOutputs(
        CapabilitySupport|array $structuredOutputs
    ): self {
        $self = clone $this;
        $self['structuredOutputs'] = $structuredOutputs;

        return $self;
    }

    /**
     * Thinking capability and supported type configurations.
     *
     * @param ThinkingCapability|ThinkingCapabilityShape $thinking
     */
    public function withThinking(ThinkingCapability|array $thinking): self
    {
        $self = clone $this;
        $self['thinking'] = $thinking;

        return $self;
    }
}
