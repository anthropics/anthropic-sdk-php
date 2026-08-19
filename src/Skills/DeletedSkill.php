<?php

declare(strict_types=1);

namespace Anthropic\Skills;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type DeletedSkillShape = array{id: string, type: 'skill_deleted'}
 */
final class DeletedSkill implements BaseModel
{
    /** @use SdkModel<DeletedSkillShape> */
    use SdkModel;

    /**
     * Deleted object type.
     *
     * For Skills, this is always `"skill_deleted"`.
     *
     * @var 'skill_deleted' $type
     */
    #[Required]
    public string $type = 'skill_deleted';

    /**
     * Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     */
    #[Required]
    public string $id;

    /**
     * `new DeletedSkill()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DeletedSkill::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DeletedSkill)->withID(...)
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
    public static function with(string $id): self
    {
        $self = new self;

        $self['id'] = $id;

        return $self;
    }

    /**
     * Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Deleted object type.
     *
     * For Skills, this is always `"skill_deleted"`.
     *
     * @param 'skill_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
