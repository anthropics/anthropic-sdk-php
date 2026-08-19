<?php

declare(strict_types=1);

namespace Anthropic\Skills\Versions;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type DeletedSkillVersionShape = array{
 *   id: string, type: 'skill_version_deleted'
 * }
 */
final class DeletedSkillVersion implements BaseModel
{
    /** @use SdkModel<DeletedSkillVersionShape> */
    use SdkModel;

    /**
     * Deleted object type.
     *
     * For Skill Versions, this is always `"skill_version_deleted"`.
     *
     * @var 'skill_version_deleted' $type
     */
    #[Required]
    public string $type = 'skill_version_deleted';

    /**
     * Unique identifier for this Skill Version. The id addresses the version in
     * paths and pins it in references.
     */
    #[Required]
    public string $id;

    /**
     * `new DeletedSkillVersion()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DeletedSkillVersion::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DeletedSkillVersion)->withID(...)
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
     * Unique identifier for this Skill Version. The id addresses the version in
     * paths and pins it in references.
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
     * For Skill Versions, this is always `"skill_version_deleted"`.
     *
     * @param 'skill_version_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
