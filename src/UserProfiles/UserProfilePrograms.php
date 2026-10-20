<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A user profile's standing in each program. A program is a set of capabilities or exemptions that Anthropic approves for the entity the profile represents. A program reads `null` when the profile has no status in it, when the caller's organization is not entitled to read programs, or when the response does not report that program. Retrieving the profile reports every program. Anthropic may add programs; ignore a key you do not recognize.
 *
 * @phpstan-import-type UserProfileCyberProgramShape from \Anthropic\UserProfiles\UserProfileCyberProgram
 * @phpstan-import-type UserProfileEfsProgramShape from \Anthropic\UserProfiles\UserProfileEfsProgram
 *
 * @phpstan-type UserProfileProgramsShape = array{
 *   cyber: null|UserProfileCyberProgram|UserProfileCyberProgramShape,
 *   efs: null|UserProfileEfsProgram|UserProfileEfsProgramShape,
 * }
 */
final class UserProfilePrograms implements BaseModel
{
    /** @use SdkModel<UserProfileProgramsShape> */
    use SdkModel;

    /**
     * The profile's standing in the Cyber Verification Program. `null` when the profile has no status in it. Only retrieving the profile gives the full answer: a list or update response can show `null`, or a status other than `active`, for a profile that reads `active` when retrieved.
     */
    #[Required]
    public ?UserProfileCyberProgram $cyber;

    /**
     * The profile's standing in Enterprise Frontier Safeguards. `null` unless the platform's attestation for the program is in place on this profile, or the entity it represents has applied to the program. A list of user profiles does not report this program: there it reads `null` for every profile, so retrieve the profile to read it.
     */
    #[Required]
    public ?UserProfileEfsProgram $efs;

    /**
     * `new UserProfilePrograms()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserProfilePrograms::with(cyber: ..., efs: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserProfilePrograms())->withCyber(...)->withEfs(...)
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
     * @param UserProfileCyberProgram|UserProfileCyberProgramShape|null $cyber
     * @param UserProfileEfsProgram|UserProfileEfsProgramShape|null $efs
     */
    public static function with(
        UserProfileCyberProgram|array|null $cyber,
        UserProfileEfsProgram|array|null $efs,
    ): self {
        $self = new self;

        $self['cyber'] = $cyber;
        $self['efs'] = $efs;

        return $self;
    }

    /**
     * The profile's standing in the Cyber Verification Program. `null` when the profile has no status in it. Only retrieving the profile gives the full answer: a list or update response can show `null`, or a status other than `active`, for a profile that reads `active` when retrieved.
     *
     * @param UserProfileCyberProgram|UserProfileCyberProgramShape|null $cyber
     */
    public function withCyber(UserProfileCyberProgram|array|null $cyber): self
    {
        $self = clone $this;
        $self['cyber'] = $cyber;

        return $self;
    }

    /**
     * The profile's standing in Enterprise Frontier Safeguards. `null` unless the platform's attestation for the program is in place on this profile, or the entity it represents has applied to the program. A list of user profiles does not report this program: there it reads `null` for every profile, so retrieve the profile to read it.
     *
     * @param UserProfileEfsProgram|UserProfileEfsProgramShape|null $efs
     */
    public function withEfs(UserProfileEfsProgram|array|null $efs): self
    {
        $self = clone $this;
        $self['efs'] = $efs;

        return $self;
    }
}
