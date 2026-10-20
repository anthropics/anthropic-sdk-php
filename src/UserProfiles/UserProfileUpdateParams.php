<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Update User Profile.
 *
 * @see Anthropic\Services\UserProfilesService::update()
 *
 * @phpstan-import-type UserProfileExternalUserDetailsParamsShape from \Anthropic\UserProfiles\UserProfileExternalUserDetailsParams
 *
 * @phpstan-type UserProfileUpdateParamsShape = array{
 *   accessType?: null|UserProfileAccessType|value-of<UserProfileAccessType>,
 *   externalUserDetails?: null|UserProfileExternalUserDetailsParams|UserProfileExternalUserDetailsParamsShape,
 *   metadata?: array<string,string>|null,
 *   name?: string|null,
 *   workspaceID?: string|null,
 * }
 */
final class UserProfileUpdateParams implements BaseModel
{
    /** @use SdkModel<UserProfileUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * If present, replaces the stored access type. Omit to leave unchanged.
     *
     * @var value-of<UserProfileAccessType>|null $accessType
     */
    #[Optional('access_type', enum: UserProfileAccessType::class, nullable: true)]
    public ?string $accessType;

    /**
     * Details about the entity this profile represents, as the platform states them. Each field sent replaces the stored value; omit a field to leave it unchanged. Once set, a value cannot be cleared and `null` is rejected. Not accepted under the legacy `user-profiles-2026-03-24` and `user-profiles-2026-08-18` beta headers.
     */
    #[Optional('external_user_details')]
    public ?UserProfileExternalUserDetailsParams $externalUserDetails;

    /**
     * Key-value pairs to merge into the stored metadata. Keys provided overwrite existing values. To remove a key, set its value to an empty string. Keys not provided are left unchanged. Maximum 16 keys, with keys up to 64 characters and values up to 512 characters.
     *
     * @var array<string,string>|null $metadata
     */
    #[Optional(map: 'string')]
    public ?array $metadata;

    /**
     * If present, replaces the stored name. Omit to leave unchanged. Maximum 255 characters.
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
     * If present, replaces the stored access type. Omit to leave unchanged.
     *
     * @param UserProfileAccessType|value-of<UserProfileAccessType>|null $accessType
     */
    public function withAccessType(
        UserProfileAccessType|string|null $accessType
    ): self {
        $self = clone $this;
        $self['accessType'] = $accessType;

        return $self;
    }

    /**
     * Details about the entity this profile represents, as the platform states them. Each field sent replaces the stored value; omit a field to leave it unchanged. Once set, a value cannot be cleared and `null` is rejected. Not accepted under the legacy `user-profiles-2026-03-24` and `user-profiles-2026-08-18` beta headers.
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
     * Key-value pairs to merge into the stored metadata. Keys provided overwrite existing values. To remove a key, set its value to an empty string. Keys not provided are left unchanged. Maximum 16 keys, with keys up to 64 characters and values up to 512 characters.
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
     * If present, replaces the stored name. Omit to leave unchanged. Maximum 255 characters.
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
