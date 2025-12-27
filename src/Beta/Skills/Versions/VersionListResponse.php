<?php

declare(strict_types=1);

namespace Anthropic\Beta\Skills\Versions;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type VersionListResponseShape = array{
 *   id: string,
 *   createdAt: string,
 *   description: string,
 *   directory: string,
 *   name: string,
 *   skillID: string,
 *   type: string,
 *   version: string,
 * }
 */
final class VersionListResponse implements BaseModel
{
    /** @use SdkModel<VersionListResponseShape> */
    use SdkModel;

    /**
     * Unique identifier for the skill version.
     *
     * The format and length of IDs may change over time.
     */
    #[Required]
    public string $id;

    /**
     * ISO 8601 timestamp of when the skill version was created.
     */
    #[Required('created_at')]
    public string $createdAt;

    /**
     * Description of the skill version.
     *
     * This is extracted from the SKILL.md file in the skill upload.
     */
    #[Required]
    public string $description;

    /**
     * Directory name of the skill version.
     *
     * This is the top-level directory name that was extracted from the uploaded files.
     */
    #[Required]
    public string $directory;

    /**
     * Human-readable name of the skill version.
     *
     * This is extracted from the SKILL.md file in the skill upload.
     */
    #[Required]
    public string $name;

    /**
     * Identifier for the skill that this version belongs to.
     */
    #[Required('skill_id')]
    public string $skillID;

    /**
     * Object type.
     *
     * For Skill Versions, this is always `"skill_version"`.
     */
    #[Required]
    public string $type;

    /**
     * Version identifier for the skill.
     *
     * Each version is identified by a Unix epoch timestamp (e.g., "1759178010641129").
     */
    #[Required]
    public string $version;

    /**
     * `new VersionListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * VersionListResponse::with(
     *   id: ...,
     *   createdAt: ...,
     *   description: ...,
     *   directory: ...,
     *   name: ...,
     *   skillID: ...,
     *   type: ...,
     *   version: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new VersionListResponse)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withDescription(...)
     *   ->withDirectory(...)
     *   ->withName(...)
     *   ->withSkillID(...)
     *   ->withType(...)
     *   ->withVersion(...)
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
        string $createdAt,
        string $description,
        string $directory,
        string $name,
        string $skillID,
        string $version,
        string $type = 'skill_version',
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['description'] = $description;
        $self['directory'] = $directory;
        $self['name'] = $name;
        $self['skillID'] = $skillID;
        $self['type'] = $type;
        $self['version'] = $version;

        return $self;
    }

    /**
     * Unique identifier for the skill version.
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
     * ISO 8601 timestamp of when the skill version was created.
     */
    public function withCreatedAt(string $createdAt): self
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
     * Directory name of the skill version.
     *
     * This is the top-level directory name that was extracted from the uploaded files.
     */
    public function withDirectory(string $directory): self
    {
        $self = clone $this;
        $self['directory'] = $directory;

        return $self;
    }

    /**
     * Human-readable name of the skill version.
     *
     * This is extracted from the SKILL.md file in the skill upload.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Identifier for the skill that this version belongs to.
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
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Version identifier for the skill.
     *
     * Each version is identified by a Unix epoch timestamp (e.g., "1759178010641129").
     */
    public function withVersion(string $version): self
    {
        $self = clone $this;
        $self['version'] = $version;

        return $self;
    }
}
