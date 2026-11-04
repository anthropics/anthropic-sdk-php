<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * One of the Plugin's skills has the name of an organization skill. `skill_name` is that name.
 *
 * @phpstan-type SkillNameTakenErrorDetailsShape = array{
 *   errorCode: 'skill_name_taken', skillName: string
 * }
 */
final class SkillNameTakenErrorDetails implements BaseModel
{
    /** @use SdkModel<SkillNameTakenErrorDetailsShape> */
    use SdkModel;

    /** @var 'skill_name_taken' $errorCode */
    #[Required('error_code', type: new ConstantOf('skill_name_taken'))]
    public string $errorCode = 'skill_name_taken';

    #[Required('skill_name')]
    public string $skillName;

    /**
     * `new SkillNameTakenErrorDetails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SkillNameTakenErrorDetails::with(skillName: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SkillNameTakenErrorDetails())->withSkillName(...)
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
    public static function with(string $skillName): self
    {
        $self = new self;

        $self['skillName'] = $skillName;

        return $self;
    }

    /**
     * @param 'skill_name_taken' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    public function withSkillName(string $skillName): self
    {
        $self = clone $this;
        $self['skillName'] = $skillName;

        return $self;
    }
}
