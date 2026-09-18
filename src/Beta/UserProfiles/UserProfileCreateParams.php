<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\UserProfiles\UserProfileCreateParams\AccessType;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Create User Profile.
 *
 * @see Anthropic\Services\Beta\UserProfilesService::create()
 *
 * @phpstan-import-type BetaUserProfileExternalUserDetailsParamsShape from \Anthropic\Beta\UserProfiles\BetaUserProfileExternalUserDetailsParams
 *
 * @phpstan-type UserProfileCreateParamsShape = array{
 *   accessType?: null|AccessType|value-of<AccessType>,
 *   externalID?: string|null,
 *   externalUserDetails?: null|BetaUserProfileExternalUserDetailsParams|BetaUserProfileExternalUserDetailsParamsShape,
 *   externalUserOnboardedAt?: \DateTimeInterface|null,
 *   metadata?: array<string,string>|null,
 *   name?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 *   workspaceID?: string|null,
 * }
 */
final class UserProfileCreateParams implements BaseModel
{
    /** @use SdkModel<UserProfileCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * How the platform uses the API on behalf of the entity this profile represents. `application`: the platform sells a product that uses the API behind the scenes, and the profile represents an individual end-user of that product. `passthrough`: the platform resells raw inference, and the profile identifies the resold-to company.
     *
     * @var value-of<AccessType>|null $accessType
     */
    #[Optional('access_type', enum: AccessType::class)]
    public ?string $accessType;

    /**
     * Platform's own identifier for this user. Not enforced unique. Maximum 255 characters. Accepted under the `user-profiles-2026-03-24` and `user-profiles-2026-08-18` beta headers; under `user-profiles-2026-09-04` send `external_user_details.reference_id` instead.
     */
    #[Optional('external_id', nullable: true)]
    public ?string $externalID;

    /**
     * Details about the entity this profile represents, as the platform states them. Every field is optional. Accepted under the `user-profiles-2026-09-04` beta header only.
     */
    #[Optional('external_user_details')]
    public ?BetaUserProfileExternalUserDetailsParams $externalUserDetails;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Optional('external_user_onboarded_at')]
    public ?\DateTimeInterface $externalUserOnboardedAt;

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
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

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
     * @param AccessType|value-of<AccessType>|null $accessType
     * @param BetaUserProfileExternalUserDetailsParams|BetaUserProfileExternalUserDetailsParamsShape|null $externalUserDetails
     * @param array<string,string>|null $metadata
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        AccessType|string|null $accessType = null,
        ?string $externalID = null,
        BetaUserProfileExternalUserDetailsParams|array|null $externalUserDetails = null,
        ?\DateTimeInterface $externalUserOnboardedAt = null,
        ?array $metadata = null,
        ?string $name = null,
        ?array $betas = null,
        ?string $workspaceID = null,
    ): self {
        $self = new self;

        null !== $accessType && $self['accessType'] = $accessType;
        null !== $externalID && $self['externalID'] = $externalID;
        null !== $externalUserDetails && $self['externalUserDetails'] = $externalUserDetails;
        null !== $externalUserOnboardedAt && $self['externalUserOnboardedAt'] = $externalUserOnboardedAt;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $name && $self['name'] = $name;
        null !== $betas && $self['betas'] = $betas;
        null !== $workspaceID && $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * How the platform uses the API on behalf of the entity this profile represents. `application`: the platform sells a product that uses the API behind the scenes, and the profile represents an individual end-user of that product. `passthrough`: the platform resells raw inference, and the profile identifies the resold-to company.
     *
     * @param AccessType|value-of<AccessType> $accessType
     */
    public function withAccessType(AccessType|string $accessType): self
    {
        $self = clone $this;
        $self['accessType'] = $accessType;

        return $self;
    }

    /**
     * Platform's own identifier for this user. Not enforced unique. Maximum 255 characters. Accepted under the `user-profiles-2026-03-24` and `user-profiles-2026-08-18` beta headers; under `user-profiles-2026-09-04` send `external_user_details.reference_id` instead.
     */
    public function withExternalID(?string $externalID): self
    {
        $self = clone $this;
        $self['externalID'] = $externalID;

        return $self;
    }

    /**
     * Details about the entity this profile represents, as the platform states them. Every field is optional. Accepted under the `user-profiles-2026-09-04` beta header only.
     *
     * @param BetaUserProfileExternalUserDetailsParams|BetaUserProfileExternalUserDetailsParamsShape $externalUserDetails
     */
    public function withExternalUserDetails(
        BetaUserProfileExternalUserDetailsParams|array $externalUserDetails
    ): self {
        $self = clone $this;
        $self['externalUserDetails'] = $externalUserDetails;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withExternalUserOnboardedAt(
        \DateTimeInterface $externalUserOnboardedAt
    ): self {
        $self = clone $this;
        $self['externalUserOnboardedAt'] = $externalUserOnboardedAt;

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
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

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
