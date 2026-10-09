<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The session's primary thread can consult `model` mid-turn.
 *
 * @phpstan-type BetaManagedAgentsMultiagentAdvisorEnabledParamsShape = array{
 *   model: string, type: 'enabled'
 * }
 */
final class BetaManagedAgentsMultiagentAdvisorEnabledParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMultiagentAdvisorEnabledParamsShape> */
    use SdkModel;

    /** @var 'enabled' $type */
    #[Required(type: new ConstantOf('enabled'))]
    public string $type = 'enabled';

    /**
     * A Claude model id. The model must be permitted as an advisor for this agent's model.
     */
    #[Required]
    public string $model;

    /**
     * `new BetaManagedAgentsMultiagentAdvisorEnabledParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsMultiagentAdvisorEnabledParams::with(model: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsMultiagentAdvisorEnabledParams())->withModel(...)
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
     * @param 'enabled' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
