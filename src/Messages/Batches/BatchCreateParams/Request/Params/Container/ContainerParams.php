<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches\BatchCreateParams\Request\Params\Container;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Batches\BatchCreateParams\Request\Params\Container\ContainerParams\Skill;

/**
 * Container parameters with skills to be loaded.
 *
 * @phpstan-import-type SkillShape from \Anthropic\Messages\Batches\BatchCreateParams\Request\Params\Container\ContainerParams\Skill
 *
 * @phpstan-type ContainerParamsShape = array{
 *   id?: string|null, skills?: list<Skill|SkillShape>|null
 * }
 */
final class ContainerParams implements BaseModel
{
    /** @use SdkModel<ContainerParamsShape> */
    use SdkModel;

    /**
     * Container id.
     */
    #[Optional(nullable: true)]
    public ?string $id;

    /**
     * List of skills to load in the container.
     *
     * @var list<Skill>|null $skills
     */
    #[Optional(list: Skill::class, nullable: true)]
    public ?array $skills;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Skill|SkillShape>|null $skills
     */
    public static function with(?string $id = null, ?array $skills = null): self
    {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $skills && $self['skills'] = $skills;

        return $self;
    }

    /**
     * Container id.
     */
    public function withID(?string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * List of skills to load in the container.
     *
     * @param list<Skill|SkillShape>|null $skills
     */
    public function withSkills(?array $skills): self
    {
        $self = clone $this;
        $self['skills'] = $skills;

        return $self;
    }
}
