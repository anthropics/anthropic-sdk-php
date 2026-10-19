<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A user profile's standing in the Cyber Verification Program, which relaxes cyber safeguards for requests that name the profile.
 *
 * @phpstan-import-type UserProfileCyberRequirementsShape from \Anthropic\UserProfiles\UserProfileCyberRequirements
 * @phpstan-import-type UserProfileCyberTierShape from \Anthropic\UserProfiles\UserProfileCyberTier
 *
 * @phpstan-type UserProfileCyberProgramShape = array{
 *   requirements: null|UserProfileCyberRequirements|UserProfileCyberRequirementsShape,
 *   status: UserProfileProgramStatus|value-of<UserProfileProgramStatus>,
 *   tiers: array<string,UserProfileCyberTier|UserProfileCyberTierShape>,
 * }
 */
final class UserProfileCyberProgram implements BaseModel
{
    /** @use SdkModel<UserProfileCyberProgramShape> */
    use SdkModel;

    /**
     * What a request that names the profile must allow to get the relaxed safeguards of every `active` tier. `null` when no tier is `active`, and wherever `tiers` is `{}`.
     */
    #[Required]
    public ?UserProfileCyberRequirements $requirements;

    /**
     * `active` when at least one tier is `active`, or when the profile has the program's access to earlier models. That access is not a tier: a profile that has it alone reads `active` with every tier `inactive`, or with `tiers` `{}` on a response that does not report tiers. When nothing is `active`, `pending` means that an application or enrollment is under review, or that what Anthropic approved does not yet apply to this profile, and `rejected` means that the application or enrollment was declined.
     *
     * @var value-of<UserProfileProgramStatus> $status
     */
    #[Required(enum: UserProfileProgramStatus::class)]
    public string $status;

    /**
     * The program's tiers, keyed by tier: `a` (Specialized Access), `b` (Red Team Access) and `c` (Defense Access). A response reports either every tier or none. When it reports them, as retrieving the profile normally does, every tier has a key, whether or not it applies to the profile. When it does not, as in the list of user profiles, `tiers` is `{}`, which does not mean that the tiers are inactive. No tier implies another, so read the tier you need. Anthropic may add tiers; ignore a key you do not recognize.
     *
     * @var array<string,UserProfileCyberTier> $tiers
     */
    #[Required(map: UserProfileCyberTier::class)]
    public array $tiers;

    /**
     * `new UserProfileCyberProgram()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserProfileCyberProgram::with(requirements: ..., status: ..., tiers: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserProfileCyberProgram())
     *   ->withRequirements(...)
     *   ->withStatus(...)
     *   ->withTiers(...)
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
     * @param UserProfileCyberRequirements|UserProfileCyberRequirementsShape|null $requirements
     * @param UserProfileProgramStatus|value-of<UserProfileProgramStatus> $status
     * @param array<string,UserProfileCyberTier|UserProfileCyberTierShape> $tiers
     */
    public static function with(
        UserProfileCyberRequirements|array|null $requirements,
        UserProfileProgramStatus|string $status,
        array $tiers,
    ): self {
        $self = new self;

        $self['requirements'] = $requirements;
        $self['status'] = $status;
        $self['tiers'] = $tiers;

        return $self;
    }

    /**
     * What a request that names the profile must allow to get the relaxed safeguards of every `active` tier. `null` when no tier is `active`, and wherever `tiers` is `{}`.
     *
     * @param UserProfileCyberRequirements|UserProfileCyberRequirementsShape|null $requirements
     */
    public function withRequirements(
        UserProfileCyberRequirements|array|null $requirements
    ): self {
        $self = clone $this;
        $self['requirements'] = $requirements;

        return $self;
    }

    /**
     * `active` when at least one tier is `active`, or when the profile has the program's access to earlier models. That access is not a tier: a profile that has it alone reads `active` with every tier `inactive`, or with `tiers` `{}` on a response that does not report tiers. When nothing is `active`, `pending` means that an application or enrollment is under review, or that what Anthropic approved does not yet apply to this profile, and `rejected` means that the application or enrollment was declined.
     *
     * @param UserProfileProgramStatus|value-of<UserProfileProgramStatus> $status
     */
    public function withStatus(UserProfileProgramStatus|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * The program's tiers, keyed by tier: `a` (Specialized Access), `b` (Red Team Access) and `c` (Defense Access). A response reports either every tier or none. When it reports them, as retrieving the profile normally does, every tier has a key, whether or not it applies to the profile. When it does not, as in the list of user profiles, `tiers` is `{}`, which does not mean that the tiers are inactive. No tier implies another, so read the tier you need. Anthropic may add tiers; ignore a key you do not recognize.
     *
     * @param array<string,UserProfileCyberTier|UserProfileCyberTierShape> $tiers
     */
    public function withTiers(array $tiers): self
    {
        $self = clone $this;
        $self['tiers'] = $tiers;

        return $self;
    }
}
