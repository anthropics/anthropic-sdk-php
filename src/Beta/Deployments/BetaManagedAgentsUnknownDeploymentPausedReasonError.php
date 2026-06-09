<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Beta\Deployments\BetaManagedAgentsUnknownDeploymentPausedReasonError\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * An unrecognized error auto-paused the deployment. A fallback variant; matches a run whose `error.type` is `unknown_error`.
 *
 * @phpstan-type BetaManagedAgentsUnknownDeploymentPausedReasonErrorShape = array{
 *   type: Type|value-of<Type>
 * }
 */
final class BetaManagedAgentsUnknownDeploymentPausedReasonError implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsUnknownDeploymentPausedReasonErrorShape> */
    use SdkModel;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsUnknownDeploymentPausedReasonError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsUnknownDeploymentPausedReasonError::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsUnknownDeploymentPausedReasonError)->withType(...)
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
