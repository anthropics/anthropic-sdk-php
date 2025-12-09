<?php

declare(strict_types=1);

namespace Anthropic\Beta\Skills\Versions;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type VersionGetResponseShape = array{
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
final class VersionGetResponse implements BaseModel
{
    /** @use SdkModel<VersionGetResponseShape> */
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
     * `new VersionGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * VersionGetResponse::with(
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
     * (new VersionGetResponse)
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
        $obj = new self;

        $obj['id'] = $id;
        $obj['createdAt'] = $createdAt;
        $obj['description'] = $description;
        $obj['directory'] = $directory;
        $obj['name'] = $name;
        $obj['skillID'] = $skillID;
        $obj['type'] = $type;
        $obj['version'] = $version;

        return $obj;
    }

    /**
     * Unique identifier for the skill version.
     *
     * The format and length of IDs may change over time.
     */
    public function withID(string $id): self
    {
        $obj = clone $this;
        $obj['id'] = $id;

        return $obj;
    }

    /**
     * ISO 8601 timestamp of when the skill version was created.
     */
    public function withCreatedAt(string $createdAt): self
    {
        $obj = clone $this;
        $obj['createdAt'] = $createdAt;

        return $obj;
    }

    /**
     * Description of the skill version.
     *
     * This is extracted from the SKILL.md file in the skill upload.
     */
    public function withDescription(string $description): self
    {
        $obj = clone $this;
        $obj['description'] = $description;

        return $obj;
    }

    /**
     * Directory name of the skill version.
     *
     * This is the top-level directory name that was extracted from the uploaded files.
     */
    public function withDirectory(string $directory): self
    {
        $obj = clone $this;
        $obj['directory'] = $directory;

        return $obj;
    }

    /**
     * Human-readable name of the skill version.
     *
     * This is extracted from the SKILL.md file in the skill upload.
     */
    public function withName(string $name): self
    {
        $obj = clone $this;
        $obj['name'] = $name;

        return $obj;
    }

    /**
     * Identifier for the skill that this version belongs to.
     */
    public function withSkillID(string $skillID): self
    {
        $obj = clone $this;
        $obj['skillID'] = $skillID;

        return $obj;
    }

    /**
     * Object type.
     *
     * For Skill Versions, this is always `"skill_version"`.
     */
    public function withType(string $type): self
    {
        $obj = clone $this;
        $obj['type'] = $type;

        return $obj;
    }

    /**
     * Version identifier for the skill.
     *
     * Each version is identified by a Unix epoch timestamp (e.g., "1759178010641129").
     */
    public function withVersion(string $version): self
    {
        $obj = clone $this;
        $obj['version'] = $version;

        return $obj;
    }
}
