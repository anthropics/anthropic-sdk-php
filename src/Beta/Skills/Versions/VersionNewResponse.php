<?php

declare(strict_types=1);

namespace Anthropic\Beta\Skills\Versions;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkResponse;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\Contracts\ResponseConverter;

/**
 * @phpstan-type VersionNewResponseShape = array{
 *   id: string,
 *   created_at: string,
 *   description: string,
 *   directory: string,
 *   name: string,
 *   skill_id: string,
 *   type: string,
 *   version: string,
 * }
 */
final class VersionNewResponse implements BaseModel, ResponseConverter
{
    /** @use SdkModel<VersionNewResponseShape> */
    use SdkModel;

    use SdkResponse;

    /**
     * Unique identifier for the skill version.
     *
     * The format and length of IDs may change over time.
     */
    #[Api]
    public string $id;

    /**
     * ISO 8601 timestamp of when the skill version was created.
     */
    #[Api]
    public string $created_at;

    /**
     * Description of the skill version.
     *
     * This is extracted from the SKILL.md file in the skill upload.
     */
    #[Api]
    public string $description;

    /**
     * Directory name of the skill version.
     *
     * This is the top-level directory name that was extracted from the uploaded files.
     */
    #[Api]
    public string $directory;

    /**
     * Human-readable name of the skill version.
     *
     * This is extracted from the SKILL.md file in the skill upload.
     */
    #[Api]
    public string $name;

    /**
     * Identifier for the skill that this version belongs to.
     */
    #[Api]
    public string $skill_id;

    /**
     * Object type.
     *
     * For Skill Versions, this is always `"skill_version"`.
     */
    #[Api]
    public string $type;

    /**
     * Version identifier for the skill.
     *
     * Each version is identified by a Unix epoch timestamp (e.g., "1759178010641129").
     */
    #[Api]
    public string $version;

    /**
     * `new VersionNewResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * VersionNewResponse::with(
     *   id: ...,
     *   created_at: ...,
     *   description: ...,
     *   directory: ...,
     *   name: ...,
     *   skill_id: ...,
     *   type: ...,
     *   version: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new VersionNewResponse)
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
        string $created_at,
        string $description,
        string $directory,
        string $name,
        string $skill_id,
        string $version,
        string $type = 'skill_version',
    ): self {
        $obj = new self;

        $obj['id'] = $id;
        $obj['created_at'] = $created_at;
        $obj['description'] = $description;
        $obj['directory'] = $directory;
        $obj['name'] = $name;
        $obj['skill_id'] = $skill_id;
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
        $obj['created_at'] = $createdAt;

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
        $obj['skill_id'] = $skillID;

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
