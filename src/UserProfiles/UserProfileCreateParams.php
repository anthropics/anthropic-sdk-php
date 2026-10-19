<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Create User Profile.
 *
 * @see Anthropic\Services\UserProfilesService::create()
 *
 * @phpstan-import-type UserProfileExternalUserDetailsParamsShape from \Anthropic\UserProfiles\UserProfileExternalUserDetailsParams
 *
 * @phpstan-type UserProfileCreateParamsShape = array{
 *   accessType?: null|UserProfileAccessType|value-of<UserProfileAccessType>,
 *   externalUserDetails?: null|UserProfileExternalUserDetailsParams|UserProfileExternalUserDetailsParamsShape,
 *   metadata?: array<string,string>|null,
 *   name?: string|null,
 *   workspaceID?: string|null,
 * }
 */
final class UserProfileCreateParams implements BaseModel
{
    /** @use SdkModel<UserProfileCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * How the platform uses the API for this entity. `application` (default): the profile represents an individual end-user of the platform's product. `passthrough`: the profile identifies a company the platform resells Claude access to.
     *
     * @var value-of<UserProfileAccessType>|null $accessType
     */
    #[Optional('access_type', enum: UserProfileAccessType::class)]
    public ?string $accessType;

    /**
     * Details about the entity this profile represents, as the platform states them. Every field is optional. Not accepted under the legacy `user-profiles-2026-03-24` and `user-profiles-2026-08-18` beta headers, which take the top-level `external_id` (and, under `user-profiles-2026-08-18`, `external_user_onboarded_at`) instead.
     */
    #[Optional('external_user_details')]
    public ?UserProfileExternalUserDetailsParams $externalUserDetails;

    /**
     * Free-form key-value data to attach to this user profile. Maximum 16 keys, with keys up to 64 characters and values up to 512 characters. Values must be non-empty strings.
     *
     * @var array<string,string>|null $metadata
     */
    #[Optional(map: 'string')]
    public ?array $metadata;

    /**
     * Optional for all profiles. Real-world name of the entity this profile represents (company or individual); for a company the platform resells Claude access to (`access_type` `passthrough`), that company's name where known. Maximum 255 characters.
     */
    #[Optional(nullable: true)]
    public ?string $name;

    /**
     * Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     */
    #[Optional]
    public ?string $workspaceID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param UserProfileAccessType|value-of<UserProfileAccessType>|null $accessType
     * @param UserProfileExternalUserDetailsParams|UserProfileExternalUserDetailsParamsShape|null $externalUserDetails
     * @param array<string,string>|null $metadata
     */
    public static function with(
        UserProfileAccessType|string|null $accessType = null,
        UserProfileExternalUserDetailsParams|array|null $externalUserDetails = null,
        ?array $metadata = null,
        ?string $name = null,
        ?string $workspaceID = null,
    ): self {
        $self = new self;

        null !== $accessType && $self['accessType'] = $accessType;
        null !== $externalUserDetails && $self['externalUserDetails'] = $externalUserDetails;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $name && $self['name'] = $name;
        null !== $workspaceID && $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * How the platform uses the API for this entity. `application` (default): the profile represents an individual end-user of the platform's product. `passthrough`: the profile identifies a company the platform resells Claude access to.
     *
     * @param UserProfileAccessType|value-of<UserProfileAccessType> $accessType
     */
    public function withAccessType(
        UserProfileAccessType|string $accessType
    ): self {
        $self = clone $this;
        $self['accessType'] = $accessType;

        return $self;
    }

    /**
     * Details about the entity this profile represents, as the platform states them. Every field is optional. Not accepted under the legacy `user-profiles-2026-03-24` and `user-profiles-2026-08-18` beta headers, which take the top-level `external_id` (and, under `user-profiles-2026-08-18`, `external_user_onboarded_at`) instead.
     *
     * @param UserProfileExternalUserDetailsParams|UserProfileExternalUserDetailsParamsShape $externalUserDetails
     */
    public function withExternalUserDetails(
        UserProfileExternalUserDetailsParams|array $externalUserDetails
    ): self {
        $self = clone $this;
        $self['externalUserDetails'] = $externalUserDetails;

        return $self;
    }

    /**
     * Free-form key-value data to attach to this user profile. Maximum 16 keys, with keys up to 64 characters and values up to 512 characters. Values must be non-empty strings.
     *
     * @param array<string,string> $metadata
     */
    public function withMetadata(array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Optional for all profiles. Real-world name of the entity this profile represents (company or individual); for a company the platform resells Claude access to (`access_type` `passthrough`), that company's name where known. Maximum 255 characters.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
