<?php

declare(strict_types=1);

namespace Anthropic\Beta\Skills;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type SkillNewResponseShape = array{
 *   id: string,
 *   createdAt: string,
 *   displayTitle: string|null,
 *   latestVersion: string|null,
 *   source: string,
 *   type: string,
 *   updatedAt: string,
 * }
 */
final class SkillNewResponse implements BaseModel
{
    /** @use SdkModel<SkillNewResponseShape> */
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
    #[Required('created_at')]
    public string $createdAt;

    /**
     * Display title for the skill.
     *
     * This is a human-readable label that is not included in the prompt sent to the model.
     */
    #[Required('display_title')]
    public ?string $displayTitle;

    /**
     * The latest version identifier for the skill.
     *
     * This represents the most recent version of the skill that has been created.
     */
    #[Required('latest_version')]
    public ?string $latestVersion;

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
    #[Required('updated_at')]
    public string $updatedAt;

    /**
     * `new SkillNewResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SkillNewResponse::with(
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
     * (new SkillNewResponse)
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

        $obj['id'] = $id;
        $obj['createdAt'] = $createdAt;
        $obj['displayTitle'] = $displayTitle;
        $obj['latestVersion'] = $latestVersion;
        $obj['source'] = $source;
        $obj['type'] = $type;
        $obj['updatedAt'] = $updatedAt;

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
        $obj['createdAt'] = $createdAt;

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
        $obj['displayTitle'] = $displayTitle;

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
        $obj['latestVersion'] = $latestVersion;

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
        $obj['updatedAt'] = $updatedAt;

        return $obj;
    }
}
