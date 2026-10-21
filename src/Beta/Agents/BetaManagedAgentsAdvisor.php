<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Platform advisor roster entry: a model the session's primary thread may consult mid-turn.
 *
 * @phpstan-type BetaManagedAgentsAdvisorShape = array{
 *   model: string, type: 'advisor'
 * }
 */
final class BetaManagedAgentsAdvisor implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAdvisorShape> */
    use SdkModel;

    /** @var 'advisor' $type */
    #[Required(type: new ConstantOf('advisor'))]
    public string $type = 'advisor';

    /**
     * The advisor model id.
     */
    #[Required]
    public string $model;

    /**
     * `new BetaManagedAgentsAdvisor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAdvisor::with(model: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAdvisor())->withModel(...)
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
     * The advisor model id.
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
