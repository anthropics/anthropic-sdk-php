<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A skill referenced by the deployment's agent no longer exists.
 *
 * @phpstan-type BetaManagedAgentsSkillNotFoundDeploymentPausedReasonErrorShape = array{
 *   type: 'skill_not_found_error'
 * }
 */
final class BetaManagedAgentsSkillNotFoundDeploymentPausedReasonError implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSkillNotFoundDeploymentPausedReasonErrorShape> */
    use SdkModel;

    /** @var 'skill_not_found_error' $type */
    #[Required(type: new ConstantOf('skill_not_found_error'))]
    public string $type = 'skill_not_found_error';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }

    /**
     * @param 'skill_not_found_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
