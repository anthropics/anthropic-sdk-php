<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\ContainerSkill\Type;

/**
 * A skill that was loaded in a container (response model).
 *
 * @phpstan-type ContainerSkillShape = array{
 *   skillID: string, type: Type|value-of<Type>, version: string
 * }
 */
final class ContainerSkill implements BaseModel
{
    /** @use SdkModel<ContainerSkillShape> */
    use SdkModel;

    /**
     * Skill ID.
     */
    #[Required('skill_id')]
    public string $skillID;

    /**
     * Type of skill - either 'anthropic' (built-in) or 'custom' (user-defined).
     *
     * @var value-of<Type> $type
     */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * The resolved version: a skill version ID for custom skills.
     */
    #[Required]
    public string $version;

    /**
     * `new ContainerSkill()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ContainerSkill::with(skillID: ..., type: ..., version: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ContainerSkill)->withSkillID(...)->withType(...)->withVersion(...)
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
    public static function with(
        string $skillID,
        Type|string $type,
        string $version
    ): self {
        $self = new self;

        $self['skillID'] = $skillID;
        $self['type'] = $type;
        $self['version'] = $version;

        return $self;
    }

    /**
     * Skill ID.
     */
    public function withSkillID(string $skillID): self
    {
        $self = clone $this;
        $self['skillID'] = $skillID;

        return $self;
    }

    /**
     * Type of skill - either 'anthropic' (built-in) or 'custom' (user-defined).
     *
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The resolved version: a skill version ID for custom skills.
     */
    public function withVersion(string $version): self
    {
        $self = clone $this;
        $self['version'] = $version;

        return $self;
    }
}
