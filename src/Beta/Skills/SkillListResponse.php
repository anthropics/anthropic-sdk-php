<?php

declare(strict_types=1);

namespace Anthropic\Beta\Skills;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkResponse;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\Contracts\ResponseConverter;

/**
 * @phpstan-type skill_list_response = array{
 *   id: string,
 *   createdAt: string,
 *   displayTitle: string|null,
 *   latestVersion: string|null,
 *   source: string,
 *   type: string,
 *   updatedAt: string,
 * }
 */
final class SkillListResponse implements BaseModel, ResponseConverter
{
    /** @use SdkModel<skill_list_response> */
    use SdkModel;

    use SdkResponse;

    /**
     * Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     */
    #[Api]
    public string $id;

    /**
     * ISO 8601 timestamp of when the skill was created.
     */
    #[Api('created_at')]
    public string $createdAt;

    /**
     * Display title for the skill.
     *
     * This is a human-readable label that is not included in the prompt sent to the model.
     */
    #[Api('display_title')]
    public ?string $displayTitle;

    /**
     * The latest version identifier for the skill.
     *
     * This represents the most recent version of the skill that has been created.
     */
    #[Api('latest_version')]
    public ?string $latestVersion;

    /**
     * Source of the skill.
     *
     * This may be one of the following values:
     * * `"custom"`: the skill was created by a user
     * * `"anthropic"`: the skill was created by Anthropic
     */
    #[Api]
    public string $source;

    /**
     * Object type.
     *
     * For Skills, this is always `"skill"`.
     */
    #[Api]
    public string $type;

    /**
     * ISO 8601 timestamp of when the skill was last updated.
     */
    #[Api('updated_at')]
    public string $updatedAt;

    /**
     * `new SkillListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SkillListResponse::with(
     *   id: ...,
     *   createdAt: ...,
     *   displayTitle: ...,
     *   latestVersion: ...,
     *   source: ...,
     *   type: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SkillListResponse)
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
        string $createdAt,
        ?string $displayTitle,
        ?string $latestVersion,
        string $source,
        string $updatedAt,
        string $type = 'skill',
    ): self {
        $obj = new self;

        $obj->id = $id;
        $obj->createdAt = $createdAt;
        $obj->displayTitle = $displayTitle;
        $obj->latestVersion = $latestVersion;
        $obj->source = $source;
        $obj->type = $type;
        $obj->updatedAt = $updatedAt;

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
        $obj->id = $id;

        return $obj;
    }

    /**
     * ISO 8601 timestamp of when the skill was created.
     */
    public function withCreatedAt(string $createdAt): self
    {
        $obj = clone $this;
        $obj->createdAt = $createdAt;

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
        $obj->displayTitle = $displayTitle;

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
        $obj->latestVersion = $latestVersion;

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
        $obj->source = $source;

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
        $obj->type = $type;

        return $obj;
    }

    /**
     * ISO 8601 timestamp of when the skill was last updated.
     */
    public function withUpdatedAt(string $updatedAt): self
    {
        $obj = clone $this;
        $obj->updatedAt = $updatedAt;

        return $obj;
    }
}
