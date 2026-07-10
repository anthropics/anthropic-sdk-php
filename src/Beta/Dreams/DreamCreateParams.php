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
 * Create a Dream.
 *
 * @see Anthropic\Services\Beta\DreamsService::create()
 *
 * @phpstan-import-type BetaDreamInputVariants from \Anthropic\Beta\Dreams\BetaDreamInput
 * @phpstan-import-type ModelVariants from \Anthropic\Beta\Dreams\DreamCreateParams\Model
 * @phpstan-import-type BetaDreamInputShape from \Anthropic\Beta\Dreams\BetaDreamInput
 * @phpstan-import-type ModelShape from \Anthropic\Beta\Dreams\DreamCreateParams\Model
 *
 * @phpstan-type DreamCreateParamsShape = array{
 *   inputs: list<BetaDreamInputShape>,
 *   model: ModelShape,
 *   instructions?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class DreamCreateParams implements BaseModel
{
    /** @use SdkModel<DreamCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /** @var list<BetaDreamInputVariants> $inputs */
    #[Required(list: BetaDreamInput::class)]
    public array $inputs;

    /**
     * Model identifier and configuration applied to every pipeline stage.
     *
     * @var ModelVariants $model
     */
    #[Required]
    public string|BetaDreamModelConfigParam $model;

    #[Optional(nullable: true)]
    public ?string $instructions;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        array $inputs,
        string|BetaDreamModelConfigParam|array $model,
        ?string $instructions = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['inputs'] = $inputs;
        $self['model'] = $model;

        null !== $instructions && $self['instructions'] = $instructions;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * @param list<BetaDreamInputShape> $inputs
     */
    public function withInputs(array $inputs): self
    {
        $self = clone $this;
        $self['inputs'] = $inputs;

        return $self;
    }

    /**
     * Model identifier and configuration applied to every pipeline stage.
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

    public function withInstructions(?string $instructions): self
    {
        $self = clone $this;
        $self['instructions'] = $instructions;

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
}
