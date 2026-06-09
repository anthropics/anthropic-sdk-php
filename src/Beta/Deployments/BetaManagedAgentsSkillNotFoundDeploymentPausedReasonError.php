<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Beta\Deployments\BetaManagedAgentsSkillNotFoundDeploymentPausedReasonError\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A skill referenced by the deployment's agent no longer exists.
 *
 * @phpstan-type BetaManagedAgentsSkillNotFoundDeploymentPausedReasonErrorShape = array{
 *   type: Type|value-of<Type>
 * }
 */
final class BetaManagedAgentsSkillNotFoundDeploymentPausedReasonError implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSkillNotFoundDeploymentPausedReasonErrorShape> */
    use SdkModel;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsSkillNotFoundDeploymentPausedReasonError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsSkillNotFoundDeploymentPausedReasonError::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsSkillNotFoundDeploymentPausedReasonError)->withType(...)
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
    public static function with(Type|string $type): self
    {
        $self = new self;

        $self['type'] = $type;

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
