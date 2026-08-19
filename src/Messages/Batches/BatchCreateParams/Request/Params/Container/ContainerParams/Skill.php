<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches\BatchCreateParams\Request\Params\Container\ContainerParams;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Batches\BatchCreateParams\Request\Params\Container\ContainerParams\Skill\Type;

/**
 * Specification for a skill to be loaded in a container (request model).
 *
 * @phpstan-type SkillShape = array{
 *   skillID: string, type: Type|value-of<Type>, version?: string|null
 * }
 */
final class Skill implements BaseModel
{
    /** @use SdkModel<SkillShape> */
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
     * `new Skill()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Skill::with(skillID: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Skill)->withSkillID(...)->withType(...)
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
