<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaSkill\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A skill that was loaded in a container (response model).
 *
 * @phpstan-type BetaSkillShape = array{
 *   skillID: string, type: Type|value-of<Type>, version: string
 * }
 */
final class BetaSkill implements BaseModel
{
    /** @use SdkModel<BetaSkillShape> */
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
     * Skill version or 'latest' for most recent version.
     */
    #[Required]
    public string $version;

    /**
     * `new BetaSkill()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaSkill::with(skillID: ..., type: ..., version: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaSkill)->withSkillID(...)->withType(...)->withVersion(...)
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
     * Skill version or 'latest' for most recent version.
     */
    public function withVersion(string $version): self
    {
        $self = clone $this;
        $self['version'] = $version;

        return $self;
    }
}
