<?php

declare(strict_types=1);

namespace Anthropic\Skills\Versions;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Delete Skill Version.
 *
 * @see Anthropic\Services\Skills\VersionsService::delete()
 *
 * @phpstan-type VersionDeleteParamsShape = array{skillID: string}
 */
final class VersionDeleteParams implements BaseModel
{
    /** @use SdkModel<VersionDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     */
    #[Required]
    public string $skillID;

    /**
     * `new VersionDeleteParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * VersionDeleteParams::with(skillID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new VersionDeleteParams)->withSkillID(...)
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
    public static function with(string $skillID): self
    {
        $self = new self;

        $self['skillID'] = $skillID;

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
}
