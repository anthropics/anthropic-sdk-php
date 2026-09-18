<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Start an asynchronous job that uses past sessions to produce a reorganized version of a memory store and get back the dream to poll for the result.
 *
 * By default the dream writes its result to a new memory store and doesn't change the input memory store. The response has `status` set to `pending` and an empty `outputs` array. Poll the dream until `status` is `completed`, `failed`, or `canceled`.
 *
 * See the [Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#create-a-dream) to learn more about creating dreams.
 *
 * @see Anthropic\Services\Beta\DreamsService::create()
 *
 * @phpstan-import-type BetaDreamInputVariants from \Anthropic\Beta\Dreams\BetaDreamInput
 * @phpstan-import-type ModelVariants from \Anthropic\Beta\Dreams\DreamCreateParams\Model
 * @phpstan-import-type BetaOutputBehaviorVariants from \Anthropic\Beta\Dreams\BetaOutputBehavior
 * @phpstan-import-type BetaDreamInputShape from \Anthropic\Beta\Dreams\BetaDreamInput
 * @phpstan-import-type ModelShape from \Anthropic\Beta\Dreams\DreamCreateParams\Model
 * @phpstan-import-type BetaOutputBehaviorShape from \Anthropic\Beta\Dreams\BetaOutputBehavior
 *
 * @phpstan-type DreamCreateParamsShape = array{
 *   inputs: list<BetaDreamInputShape>,
 *   model: ModelShape,
 *   instructions?: string|null,
 *   outputBehavior?: BetaOutputBehaviorShape|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 *   workspaceID?: string|null,
 * }
 */
final class DreamCreateParams implements BaseModel
{
    /** @use SdkModel<DreamCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The memory store and sessions for the dream to read, as exactly one `memory_store` entry and exactly one `sessions` entry.
     *
     * @var list<BetaDreamInputVariants> $inputs
     */
    #[Required(list: BetaDreamInput::class)]
    public array $inputs;

    /**
     * The model that runs a dream, given as a model ID or as an object with `id` and `speed`.
     *
     * In the object form, `speed` can only be `standard`.
     *
     * The [limits table in the Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#limits) lists the supported models.
     *
     * @var ModelVariants $model
     */
    #[Required]
    public string|BetaDreamModelConfigParam $model;

    /**
     * Guidance that steers how the dream reads the sessions and organizes the output memory store, from 1 to 4,096 characters.
     *
     * See the [Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#steer-with-instructions) for what kinds of instructions work well.
     */
    #[Optional(nullable: true)]
    public ?string $instructions;

    /**
     * Which memory store a dream writes its result to. Defaults to `create_new` when left out of a create request.
     *
     * @var BetaOutputBehaviorVariants|null $outputBehavior
     */
    #[Optional('output_behavior', union: BetaOutputBehavior::class)]
    public BetaOutputBehaviorCreateNew|BetaOutputBehaviorUpdateExisting|null $outputBehavior;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     */
    #[Optional]
    public ?string $workspaceID;

    /**
     * `new DreamCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DreamCreateParams::with(inputs: ..., model: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DreamCreateParams)->withInputs(...)->withModel(...)
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
     * @param list<BetaDreamInputShape> $inputs
     * @param ModelShape $model
     * @param BetaOutputBehaviorShape|null $outputBehavior
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        array $inputs,
        string|BetaDreamModelConfigParam|array $model,
        ?string $instructions = null,
        BetaOutputBehaviorCreateNew|array|BetaOutputBehaviorUpdateExisting|null $outputBehavior = null,
        ?array $betas = null,
        ?string $workspaceID = null,
    ): self {
        $self = new self;

        $self['inputs'] = $inputs;
        $self['model'] = $model;

        null !== $instructions && $self['instructions'] = $instructions;
        null !== $outputBehavior && $self['outputBehavior'] = $outputBehavior;
        null !== $betas && $self['betas'] = $betas;
        null !== $workspaceID && $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * The memory store and sessions for the dream to read, as exactly one `memory_store` entry and exactly one `sessions` entry.
     *
     * @param list<BetaDreamInputShape> $inputs
     */
    public function withInputs(array $inputs): self
    {
        $self = clone $this;
        $self['inputs'] = $inputs;

        return $self;
    }

    /**
     * The model that runs a dream, given as a model ID or as an object with `id` and `speed`.
     *
     * In the object form, `speed` can only be `standard`.
     *
     * The [limits table in the Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#limits) lists the supported models.
     *
     * @param ModelShape $model
     */
    public function withModel(
        string|BetaDreamModelConfigParam|array $model
    ): self {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    /**
     * Guidance that steers how the dream reads the sessions and organizes the output memory store, from 1 to 4,096 characters.
     *
     * See the [Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#steer-with-instructions) for what kinds of instructions work well.
     */
    public function withInstructions(?string $instructions): self
    {
        $self = clone $this;
        $self['instructions'] = $instructions;

        return $self;
    }

    /**
     * Which memory store a dream writes its result to. Defaults to `create_new` when left out of a create request.
     *
     * @param BetaOutputBehaviorShape $outputBehavior
     */
    public function withOutputBehavior(
        BetaOutputBehaviorCreateNew|array|BetaOutputBehaviorUpdateExisting $outputBehavior,
    ): self {
        $self = clone $this;
        $self['outputBehavior'] = $outputBehavior;

        return $self;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }

    /**
     * Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
