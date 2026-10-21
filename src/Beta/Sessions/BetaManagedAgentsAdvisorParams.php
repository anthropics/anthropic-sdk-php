<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Platform advisor roster entry: a model the session's primary thread may consult mid-turn. At most one per roster; the entry occupies the roster name `anthropic.advisor`.
 *
 * @phpstan-type BetaManagedAgentsAdvisorParamsShape = array{
 *   model: string, type: 'advisor'
 * }
 */
final class BetaManagedAgentsAdvisorParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAdvisorParamsShape> */
    use SdkModel;

    /** @var 'advisor' $type */
    #[Required(type: new ConstantOf('advisor'))]
    public string $type = 'advisor';

    /**
     * A Claude model id. The model must be permitted as an advisor for this agent's model.
     */
    #[Required]
    public string $model;

    /**
     * `new BetaManagedAgentsAdvisorParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAdvisorParams::with(model: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAdvisorParams())->withModel(...)
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
     */
    public static function with(string $model): self
    {
        $self = new self;

        $self['model'] = $model;

        return $self;
    }

    /**
     * A Claude model id. The model must be permitted as an advisor for this agent's model.
     */
    public function withModel(string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    /**
     * @param 'advisor' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
