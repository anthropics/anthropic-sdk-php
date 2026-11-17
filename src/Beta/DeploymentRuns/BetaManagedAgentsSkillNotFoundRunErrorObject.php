<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A skill referenced by the deployment's agent no longer exists.
 *
 * @phpstan-type BetaManagedAgentsSkillNotFoundRunErrorObjectShape = array{
 *   message: string, type: 'skill_not_found_error'
 * }
 */
class BetaManagedAgentsSkillNotFoundRunErrorObject implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSkillNotFoundRunErrorObjectShape> */
    use SdkModel;

    /** @var 'skill_not_found_error' $type */
    #[Required(type: new ConstantOf('skill_not_found_error'))]
    public string $type = 'skill_not_found_error';

    /**
     * Human-readable error description.
     */
    #[Required]
    public string $message;

    /**
     * `new BetaManagedAgentsSkillNotFoundRunErrorObject()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsSkillNotFoundRunErrorObject::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsSkillNotFoundRunErrorObject())->withMessage(...)
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
    public static function with(string $message): self
    {
        $self = new self;

        $self['message'] = $message;

        return $self;
    }

    /**
     * Human-readable error description.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
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

class_alias(
    BetaManagedAgentsSkillNotFoundRunErrorObject::class,
    'Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSkillNotFoundRunError',
);
