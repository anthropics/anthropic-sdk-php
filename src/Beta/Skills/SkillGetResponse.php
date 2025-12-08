<?php

declare(strict_types=1);

namespace Anthropic\Beta\Skills;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type SkillGetResponseShape = array{
 *   id: string,
 *   created_at: string,
 *   display_title: string|null,
 *   latest_version: string|null,
 *   source: string,
 *   type: string,
 *   updated_at: string,
 * }
 */
final class SkillGetResponse implements BaseModel
{
    /** @use SdkModel<SkillGetResponseShape> */
    use SdkModel;

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
    #[Required]
    public string $created_at;

    /**
     * Display title for the skill.
     *
     * This is a human-readable label that is not included in the prompt sent to the model.
     */
    #[Required]
    public ?string $display_title;

    /**
     * The latest version identifier for the skill.
     *
     * This represents the most recent version of the skill that has been created.
     */
    #[Required]
    public ?string $latest_version;

    /**
     * Source of the skill.
     *
     * This may be one of the following values:
     * * `"custom"`: the skill was created by a user
     * * `"anthropic"`: the skill was created by Anthropic
     */
    #[Required]
    public string $source;

    /**
     * Object type.
     *
     * For Skills, this is always `"skill"`.
     */
    #[Required]
    public string $type;

    /**
     * ISO 8601 timestamp of when the skill was last updated.
     */
    #[Required]
    public string $updated_at;

    /**
     * `new SkillGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SkillGetResponse::with(
     *   id: ...,
     *   created_at: ...,
     *   display_title: ...,
     *   latest_version: ...,
     *   source: ...,
     *   type: ...,
     *   updated_at: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SkillGetResponse)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withDisplayTitle(...)
     *   ->withLatestVersion(...)
     *   ->withSource(...)
     *   ->withType(...)
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
     */
    public static function with(
        string $id,
        string $created_at,
        ?string $display_title,
        ?string $latest_version,
        string $source,
        string $updated_at,
        string $type = 'skill',
    ): self {
        $obj = new self;

        $obj['id'] = $id;
        $obj['created_at'] = $created_at;
        $obj['display_title'] = $display_title;
        $obj['latest_version'] = $latest_version;
        $obj['source'] = $source;
        $obj['type'] = $type;
        $obj['updated_at'] = $updated_at;

        return $obj;
    }

    /**
     * Unique identifier for the skill.
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
     * ISO 8601 timestamp of when the skill was created.
     */
    public function withCreatedAt(string $createdAt): self
    {
        $obj = clone $this;
        $obj['created_at'] = $createdAt;

        return $obj;
    }

    /**
     * Display title for the skill.
     *
     * This is a human-readable label that is not included in the prompt sent to the model.
     */
    public function withDisplayTitle(?string $displayTitle): self
    {
        $obj = clone $this;
        $obj['display_title'] = $displayTitle;

        return $obj;
    }

    /**
     * The latest version identifier for the skill.
     *
     * This represents the most recent version of the skill that has been created.
     */
    public function withLatestVersion(?string $latestVersion): self
    {
        $obj = clone $this;
        $obj['latest_version'] = $latestVersion;

        return $obj;
    }

    /**
     * Source of the skill.
     *
     * This may be one of the following values:
     * * `"custom"`: the skill was created by a user
     * * `"anthropic"`: the skill was created by Anthropic
     */
    public function withSource(string $source): self
    {
        $obj = clone $this;
        $obj['source'] = $source;

        return $obj;
    }

    /**
     * Object type.
     *
     * For Skills, this is always `"skill"`.
     */
    public function withType(string $type): self
    {
        $obj = clone $this;
        $obj['type'] = $type;

        return $obj;
    }

    /**
     * ISO 8601 timestamp of when the skill was last updated.
     */
    public function withUpdatedAt(string $updatedAt): self
    {
        $obj = clone $this;
        $obj['updated_at'] = $updatedAt;

        return $obj;
    }
}
