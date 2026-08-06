<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Sessions\BetaManagedAgentsAdvisorParams\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Platform advisor roster entry: a model the session's primary thread may consult mid-turn. At most one per roster; the entry occupies the roster name `anthropic.advisor`.
 *
 * @phpstan-type BetaManagedAgentsAdvisorParamsShape = array{
 *   model: string, type: Type|value-of<Type>
 * }
 */
final class BetaManagedAgentsAdvisorParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAdvisorParamsShape> */
    use SdkModel;

    /**
     * A Claude model id. The model must be permitted as an advisor for this agent's model — see the sessions/threads/advisor spec.
     */
    #[Required]
    public string $model;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsAdvisorParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAdvisorParams::with(model: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAdvisorParams)->withModel(...)->withType(...)
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
     * A Claude model id. The model must be permitted as an advisor for this agent's model — see the sessions/threads/advisor spec.
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
