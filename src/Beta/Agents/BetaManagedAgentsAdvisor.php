<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsAdvisor\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Platform advisor roster entry: a model the session's primary thread may consult mid-turn.
 *
 * @phpstan-type BetaManagedAgentsAdvisorShape = array{
 *   model: string, type: Type|value-of<Type>
 * }
 */
final class BetaManagedAgentsAdvisor implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAdvisorShape> */
    use SdkModel;

    /**
     * The advisor model id.
     */
    #[Required]
    public string $model;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsAdvisor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAdvisor::with(model: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAdvisor)->withModel(...)->withType(...)
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
     * @param Type|value-of<Type> $type
     */
    public static function with(string $model, Type|string $type): self
    {
        $self = new self;

        $self['model'] = $model;
        $self['type'] = $type;

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
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
