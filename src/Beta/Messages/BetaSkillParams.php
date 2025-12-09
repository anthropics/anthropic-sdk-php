<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaSkillParams\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Specification for a skill to be loaded in a container (request model).
 *
 * @phpstan-type BetaSkillParamsShape = array{
 *   skillID: string, type: value-of<Type>, version?: string|null
 * }
 */
final class BetaSkillParams implements BaseModel
{
    /** @use SdkModel<BetaSkillParamsShape> */
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
    #[Optional]
    public ?string $version;

    /**
     * `new BetaSkillParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaSkillParams::with(skillID: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaSkillParams)->withSkillID(...)->withType(...)
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
        ?string $version = null
    ): self {
        $self = new self;

        $self['skillID'] = $skillID;
        $self['type'] = $type;

        null !== $version && $self['version'] = $version;

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
