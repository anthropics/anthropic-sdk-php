<?php

declare(strict_types=1);

namespace Anthropic\Skills\Versions;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type SkillVersionShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   description: string,
 *   name: string,
 *   skillID: string,
 *   type: 'skill_version',
 * }
 */
final class SkillVersion implements BaseModel
{
    /** @use SdkModel<SkillVersionShape> */
    use SdkModel;

    /**
     * Object type.
     *
     * For Skill Versions, this is always `"skill_version"`.
     *
     * @var 'skill_version' $type
     */
    #[Required]
    public string $type = 'skill_version';

    /**
     * Unique identifier for this Skill Version. The id addresses the version in
     * paths and pins it in references.
     */
    #[Required]
    public string $id;

    /**
     * ISO 8601 timestamp of when the skill was created.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Description of the skill version.
     *
     * This is extracted from the SKILL.md file in the skill upload.
     */
    #[Required]
    public string $description;

    /**
     * The Skill's immutable kebab-case slug, set at creation from the first
     * upload's SKILL.md frontmatter `name` (or its enclosing directory). Every
     * later upload must resolve to the same value. Also the top-level directory
     * of the Skill's mounted files and the base name of a downloaded archive.
     */
    #[Required]
    public string $name;

    /**
     * Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     */
    #[Required('skill_id')]
    public string $skillID;

    /**
     * `new SkillVersion()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SkillVersion::with(
     *   id: ..., createdAt: ..., description: ..., name: ..., skillID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SkillVersion)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withDescription(...)
     *   ->withName(...)
     *   ->withSkillID(...)
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
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        string $description,
        string $name,
        string $skillID,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['description'] = $description;
        $self['name'] = $name;
        $self['skillID'] = $skillID;

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
     * ISO 8601 timestamp of when the skill was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Description of the skill version.
     *
     * This is extracted from the SKILL.md file in the skill upload.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * The Skill's immutable kebab-case slug, set at creation from the first
     * upload's SKILL.md frontmatter `name` (or its enclosing directory). Every
     * later upload must resolve to the same value. Also the top-level directory
     * of the Skill's mounted files and the base name of a downloaded archive.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     */
    public function withSkillID(string $skillID): self
    {
        $self = clone $this;
        $self['skillID'] = $skillID;

        return $self;
    }

    /**
     * Object type.
     *
     * For Skill Versions, this is always `"skill_version"`.
     *
     * @param 'skill_version' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
