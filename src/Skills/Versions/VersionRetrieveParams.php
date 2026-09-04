<?php

declare(strict_types=1);

namespace Anthropic\Skills\Versions;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Get Skill Version.
 *
 * @see Anthropic\Services\Skills\VersionsService::retrieve()
 *
 * @phpstan-type VersionRetrieveParamsShape = array{
 *   skillID: string, workspaceID?: string|null
 * }
 */
final class VersionRetrieveParams implements BaseModel
{
    /** @use SdkModel<VersionRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     */
    #[Required]
    public string $skillID;

    #[Optional]
    public ?string $workspaceID;

    /**
     * `new VersionRetrieveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * VersionRetrieveParams::with(skillID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new VersionRetrieveParams)->withSkillID(...)
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
        string $skillID,
        ?string $workspaceID = null
    ): self {
        $self = new self;

        $self['skillID'] = $skillID;

        null !== $workspaceID && $self['workspaceID'] = $workspaceID;

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

    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
