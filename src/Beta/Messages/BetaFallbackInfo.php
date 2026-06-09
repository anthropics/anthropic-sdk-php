<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Model;

/**
 * Identifies one hop of a fallback transition.
 *
 * @phpstan-type BetaFallbackInfoShape = array{model: string|Model|value-of<Model>}
 */
final class BetaFallbackInfo implements BaseModel
{
    /** @use SdkModel<BetaFallbackInfoShape> */
    use SdkModel;

    /**
     * The model that will complete your prompt.
     *
     * See [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     *
     * @var string|value-of<Model> $model
     */
    #[Required(enum: Model::class)]
    public string $model;

    /**
     * `new BetaFallbackInfo()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaFallbackInfo::with(model: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaFallbackInfo)->withModel(...)
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
     * @param string|Model|value-of<Model> $model
     */
    public static function with(Model|string $model): self
    {
        $self = new self;

        $self['model'] = $model;

        return $self;
    }

    /**
     * The model that will complete your prompt.
     *
     * See [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     *
     * @param string|Model|value-of<Model> $model
     */
    public function withModel(Model|string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }
}
