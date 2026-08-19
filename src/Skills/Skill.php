<?php

declare(strict_types=1);

namespace Anthropic\Skills;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type SkillSourceShape from \Anthropic\Skills\SkillSource
 *
 * @phpstan-type SkillShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   displayName: string,
 *   latestVersionID: string,
 *   source: SkillSource|SkillSourceShape,
 *   type: 'skill',
 *   updatedAt: \DateTimeInterface,
 * }
 */
final class Skill implements BaseModel
{
    /** @use SdkModel<SkillShape> */
    use SdkModel;

    /**
     * Object type.
     *
     * For Skills, this is always `"skill"`.
     *
     * @var 'skill' $type
     */
    #[Required]
    public string $type = 'skill';

    /**
     * Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     */
    #[Required]
    public string $id;

    /**
     * ISO 8601 timestamp of when the skill was created.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Human-readable, single-line label for the Skill. Maximum 255 characters.
     * Always set: derived from the SKILL.md frontmatter `name` when omitted at
     * creation. Not unique.
     */
    #[Required('display_name')]
    public string $displayName;

    /**
     * ID of the newest Skill Version — what `latest` references resolve to. Always set: a Skill holds at least one version.
     */
    #[Required('latest_version_id')]
    public string $latestVersionID;

    /**
     * Where the Skill comes from.
     *
     * Possible values:
     * * `"custom"`: authored by the platform user; private to their workspace
     * * `"anthropic"`: published by Anthropic; shared and read-only
     * * `"anthropic_example"`: Anthropic-published sample Skill
     * * `"plugin"`: resolved from an installed plugin
     */
    #[Required]
    public SkillSource $source;

    /**
     * ISO 8601 timestamp of when the skill was last updated.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * `new Skill()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Skill::with(
     *   id: ...,
     *   createdAt: ...,
     *   displayName: ...,
     *   latestVersionID: ...,
     *   source: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Skill)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withDisplayName(...)
     *   ->withLatestVersionID(...)
     *   ->withSource(...)
     *   ->withUpdatedAt(...)
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
     * @param SkillSource|SkillSourceShape $source
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        string $displayName,
        string $latestVersionID,
        SkillSource|array $source,
        \DateTimeInterface $updatedAt,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['displayName'] = $displayName;
        $self['latestVersionID'] = $latestVersionID;
        $self['source'] = $source;
        $self['updatedAt'] = $updatedAt;

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
     * ISO 8601 timestamp of when the skill was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Human-readable, single-line label for the Skill. Maximum 255 characters.
     * Always set: derived from the SKILL.md frontmatter `name` when omitted at
     * creation. Not unique.
     */
    public function withDisplayName(string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * ID of the newest Skill Version — what `latest` references resolve to. Always set: a Skill holds at least one version.
     */
    public function withLatestVersionID(string $latestVersionID): self
    {
        $self = clone $this;
        $self['latestVersionID'] = $latestVersionID;

        return $self;
    }

    /**
     * Where the Skill comes from.
     *
     * Possible values:
     * * `"custom"`: authored by the platform user; private to their workspace
     * * `"anthropic"`: published by Anthropic; shared and read-only
     * * `"anthropic_example"`: Anthropic-published sample Skill
     * * `"plugin"`: resolved from an installed plugin
     *
     * @param SkillSource|SkillSourceShape $source
     */
    public function withSource(SkillSource|array $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    /**
     * Object type.
     *
     * For Skills, this is always `"skill"`.
     *
     * @param 'skill' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * ISO 8601 timestamp of when the skill was last updated.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
