<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Container parameters with skills to be loaded.
 *
 * @phpstan-import-type SkillParamsShape from \Anthropic\Messages\SkillParams
 *
 * @phpstan-type ContainerParamsShape = array{
 *   id?: string|null, skills?: list<SkillParams|SkillParamsShape>|null
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
     * @var list<SkillParams>|null $skills
     */
    #[Optional(list: SkillParams::class, nullable: true)]
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
     * @param list<SkillParams|SkillParamsShape>|null $skills
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
     * @param list<SkillParams|SkillParamsShape>|null $skills
     */
    public function withSkills(?array $skills): self
    {
        $self = clone $this;
        $self['skills'] = $skills;

        return $self;
    }
}
