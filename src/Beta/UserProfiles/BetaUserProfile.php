<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles;

use Anthropic\Beta\UserProfiles\BetaUserProfile\AccessType;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A record of an entity that the platform serves through the API, such as an end-user of the platform's product or a company that the platform resells Claude access to.
 *
 * A Messages, Message Batches or token counting request can send a profile's `id` in the `anthropic-user-profile-id` header to attribute the request to that entity.
 *
 * @phpstan-import-type BetaUserProfileTrustGrantShape from \Anthropic\Beta\UserProfiles\BetaUserProfileTrustGrant
 * @phpstan-import-type BetaUserProfileExternalUserDetailsShape from \Anthropic\Beta\UserProfiles\BetaUserProfileExternalUserDetails
 *
 * @phpstan-type BetaUserProfileShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   metadata: array<string,string>,
 *   name: string|null,
 *   trustGrants: array<string,BetaUserProfileTrustGrant|BetaUserProfileTrustGrantShape>,
 *   type: 'user_profile',
 *   updatedAt: \DateTimeInterface,
 *   accessType?: null|AccessType|value-of<AccessType>,
 *   externalID?: string|null,
 *   externalUserDetails?: null|BetaUserProfileExternalUserDetails|BetaUserProfileExternalUserDetailsShape,
 *   externalUserOnboardedAt?: \DateTimeInterface|null,
 * }
 */
final class BetaUserProfile implements BaseModel
{
    /** @use SdkModel<BetaUserProfileShape> */
    use SdkModel;

    /**
     * Object type. Always `user_profile`.
     *
     * @var 'user_profile' $type
     */
    #[Required(type: new ConstantOf('user_profile'))]
    public string $type = 'user_profile';

    /**
     * Unique identifier for this user profile, prefixed `uprof_`.
     */
    #[Required]
    public string $id;

    /**
     * When this user profile was created, in RFC 3339 format.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Arbitrary key-value metadata. Maximum 16 pairs, keys up to 64 chars, values up to 512 chars.
     *
     * @var array<string,string> $metadata
     */
    #[Required(map: 'string')]
    public array $metadata;

    /**
     * Real-world name of the entity this profile represents (company or individual). For a company the platform resells Claude access to (`access_type` `passthrough`) this is that company's name. `null` until the platform supplies one.
     */
    #[Required]
    public ?string $name;

    /**
     * Trust grants for this profile, keyed by grant name. Key omitted when no grant is active or in flight.
     *
     * @var array<string,BetaUserProfileTrustGrant> $trustGrants
     */
    #[Required('trust_grants', map: BetaUserProfileTrustGrant::class)]
    public array $trustGrants;

    /**
     * When this user profile was last modified, in RFC 3339 format. It normally also updates shortly after Anthropic gives the profile an approval or withdraws one. Other changes to the statuses that Anthropic reports do not always update it, so read the status itself rather than watching this timestamp.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * How the platform uses the API for this entity: `application` (default) or `passthrough`. Absent under the legacy `user-profiles-2026-03-24` beta header.
     *
     * @var value-of<AccessType>|null $accessType
     */
    #[Optional('access_type', enum: AccessType::class)]
    public ?string $accessType;

    /**
     * Platform's own identifier for this user. Not enforced unique. Legacy field, present only under the `user-profiles-2026-03-24` and `user-profiles-2026-08-18` beta headers; without one of them, the value is `external_user_details.reference_id`.
     */
    #[Optional('external_id', nullable: true)]
    public ?string $externalID;

    /**
     * Details about the entity this profile represents, as the platform states them; not verified by Anthropic. Every field is present, `null` until the platform supplies a value. Absent under the legacy `user-profiles-2026-03-24` and `user-profiles-2026-08-18` beta headers, which serve `reference_id` as the top-level `external_id` and, under `user-profiles-2026-08-18`, `onboarded_at` as `external_user_onboarded_at`.
     */
    #[Optional('external_user_details')]
    public ?BetaUserProfileExternalUserDetails $externalUserDetails;

    /**
     * When the entity this profile represents opened its account with the platform, as stated by the platform, in RFC 3339 format (UTC). `null` until the platform supplies one. Legacy field, present only under the `user-profiles-2026-08-18` beta header; without a legacy header, the value is `external_user_details.onboarded_at`.
     */
    #[Optional('external_user_onboarded_at', nullable: true)]
    public ?\DateTimeInterface $externalUserOnboardedAt;

    /**
     * `new BetaUserProfile()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaUserProfile::with(
     *   id: ...,
     *   createdAt: ...,
     *   metadata: ...,
     *   name: ...,
     *   trustGrants: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaUserProfile())
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withMetadata(...)
     *   ->withName(...)
     *   ->withTrustGrants(...)
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
     *
     * @param array<string,string> $metadata
     * @param array<string,BetaUserProfileTrustGrant|BetaUserProfileTrustGrantShape> $trustGrants
     * @param AccessType|value-of<AccessType>|null $accessType
     * @param BetaUserProfileExternalUserDetails|BetaUserProfileExternalUserDetailsShape|null $externalUserDetails
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        array $metadata,
        ?string $name,
        array $trustGrants,
        \DateTimeInterface $updatedAt,
        AccessType|string|null $accessType = null,
        ?string $externalID = null,
        BetaUserProfileExternalUserDetails|array|null $externalUserDetails = null,
        ?\DateTimeInterface $externalUserOnboardedAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['metadata'] = $metadata;
        $self['name'] = $name;
        $self['trustGrants'] = $trustGrants;
        $self['updatedAt'] = $updatedAt;

        null !== $accessType && $self['accessType'] = $accessType;
        null !== $externalID && $self['externalID'] = $externalID;
        null !== $externalUserDetails && $self['externalUserDetails'] = $externalUserDetails;
        null !== $externalUserOnboardedAt && $self['externalUserOnboardedAt'] = $externalUserOnboardedAt;

        return $self;
    }

    /**
     * Unique identifier for this user profile, prefixed `uprof_`.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * When this user profile was created, in RFC 3339 format.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Arbitrary key-value metadata. Maximum 16 pairs, keys up to 64 chars, values up to 512 chars.
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
     * Real-world name of the entity this profile represents (company or individual). For a company the platform resells Claude access to (`access_type` `passthrough`) this is that company's name. `null` until the platform supplies one.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Trust grants for this profile, keyed by grant name. Key omitted when no grant is active or in flight.
     *
     * @param array<string,BetaUserProfileTrustGrant|BetaUserProfileTrustGrantShape> $trustGrants
     */
    public function withTrustGrants(array $trustGrants): self
    {
        $self = clone $this;
        $self['trustGrants'] = $trustGrants;

        return $self;
    }

    /**
     * Object type. Always `user_profile`.
     *
     * @param 'user_profile' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * When this user profile was last modified, in RFC 3339 format. It normally also updates shortly after Anthropic gives the profile an approval or withdraws one. Other changes to the statuses that Anthropic reports do not always update it, so read the status itself rather than watching this timestamp.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * How the platform uses the API for this entity: `application` (default) or `passthrough`. Absent under the legacy `user-profiles-2026-03-24` beta header.
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
     * Platform's own identifier for this user. Not enforced unique. Legacy field, present only under the `user-profiles-2026-03-24` and `user-profiles-2026-08-18` beta headers; without one of them, the value is `external_user_details.reference_id`.
     */
    public function withExternalID(?string $externalID): self
    {
        $self = clone $this;
        $self['externalID'] = $externalID;

        return $self;
    }

    /**
     * Details about the entity this profile represents, as the platform states them; not verified by Anthropic. Every field is present, `null` until the platform supplies a value. Absent under the legacy `user-profiles-2026-03-24` and `user-profiles-2026-08-18` beta headers, which serve `reference_id` as the top-level `external_id` and, under `user-profiles-2026-08-18`, `onboarded_at` as `external_user_onboarded_at`.
     *
     * @param BetaUserProfileExternalUserDetails|BetaUserProfileExternalUserDetailsShape $externalUserDetails
     */
    public function withExternalUserDetails(
        BetaUserProfileExternalUserDetails|array $externalUserDetails
    ): self {
        $self = clone $this;
        $self['externalUserDetails'] = $externalUserDetails;

        return $self;
    }

    /**
     * When the entity this profile represents opened its account with the platform, as stated by the platform, in RFC 3339 format (UTC). `null` until the platform supplies one. Legacy field, present only under the `user-profiles-2026-08-18` beta header; without a legacy header, the value is `external_user_details.onboarded_at`.
     */
    public function withExternalUserOnboardedAt(
        ?\DateTimeInterface $externalUserOnboardedAt
    ): self {
        $self = clone $this;
        $self['externalUserOnboardedAt'] = $externalUserOnboardedAt;

        return $self;
    }
}
