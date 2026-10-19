<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A record of an entity that the platform serves through the API, such as an end-user of the platform's product or a company that the platform resells Claude access to.
 *
 * A Messages, Message Batches or token counting request can send a profile's `id` in the `anthropic-user-profile-id` header to attribute the request to that entity.
 *
 * @phpstan-import-type UserProfileExternalUserDetailsShape from \Anthropic\UserProfiles\UserProfileExternalUserDetails
 * @phpstan-import-type UserProfileProgramsShape from \Anthropic\UserProfiles\UserProfilePrograms
 *
 * @phpstan-type UserProfileShape = array{
 *   id: string,
 *   accessType: UserProfileAccessType|value-of<UserProfileAccessType>,
 *   createdAt: \DateTimeInterface,
 *   externalUserDetails: UserProfileExternalUserDetails|UserProfileExternalUserDetailsShape,
 *   metadata: array<string,string>,
 *   name: string|null,
 *   programs: UserProfilePrograms|UserProfileProgramsShape,
 *   type: 'user_profile',
 *   updatedAt: \DateTimeInterface,
 * }
 */
final class UserProfile implements BaseModel
{
    /** @use SdkModel<UserProfileShape> */
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
     * How the platform uses the API for this entity: `application` (default) or `passthrough`. Absent under the legacy `user-profiles-2026-03-24` beta header.
     *
     * @var value-of<UserProfileAccessType> $accessType
     */
    #[Required('access_type', enum: UserProfileAccessType::class)]
    public string $accessType;

    /**
     * When this user profile was created, in RFC 3339 format.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Details about the entity this profile represents, as the platform states them; not verified by Anthropic. Every field is present, `null` until the platform supplies a value. Absent under the legacy `user-profiles-2026-03-24` and `user-profiles-2026-08-18` beta headers, which serve `reference_id` as the top-level `external_id` and, under `user-profiles-2026-08-18`, `onboarded_at` as `external_user_onboarded_at`.
     */
    #[Required('external_user_details')]
    public UserProfileExternalUserDetails $externalUserDetails;

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
     * The profile's standing in each Anthropic program, such as the Cyber Verification Program. Present when the request sends no user-profiles beta header; absent under the `user-profiles-2026-09-04` and earlier beta headers, which serve `trust_grants` instead.
     */
    #[Required]
    public UserProfilePrograms $programs;

    /**
     * When this user profile was last modified, in RFC 3339 format. It normally also updates shortly after Anthropic gives the profile an approval or withdraws one. Other changes to the statuses that Anthropic reports do not always update it, so read the status itself rather than watching this timestamp.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * `new UserProfile()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserProfile::with(
     *   id: ...,
     *   accessType: ...,
     *   createdAt: ...,
     *   externalUserDetails: ...,
     *   metadata: ...,
     *   name: ...,
     *   programs: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserProfile())
     *   ->withID(...)
     *   ->withAccessType(...)
     *   ->withCreatedAt(...)
     *   ->withExternalUserDetails(...)
     *   ->withMetadata(...)
     *   ->withName(...)
     *   ->withPrograms(...)
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
     * @param UserProfileAccessType|value-of<UserProfileAccessType> $accessType
     * @param UserProfileExternalUserDetails|UserProfileExternalUserDetailsShape $externalUserDetails
     * @param array<string,string> $metadata
     * @param UserProfilePrograms|UserProfileProgramsShape $programs
     */
    public static function with(
        string $id,
        UserProfileAccessType|string $accessType,
        \DateTimeInterface $createdAt,
        UserProfileExternalUserDetails|array $externalUserDetails,
        array $metadata,
        ?string $name,
        UserProfilePrograms|array $programs,
        \DateTimeInterface $updatedAt,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['accessType'] = $accessType;
        $self['createdAt'] = $createdAt;
        $self['externalUserDetails'] = $externalUserDetails;
        $self['metadata'] = $metadata;
        $self['name'] = $name;
        $self['programs'] = $programs;
        $self['updatedAt'] = $updatedAt;

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
     * How the platform uses the API for this entity: `application` (default) or `passthrough`. Absent under the legacy `user-profiles-2026-03-24` beta header.
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
     * When this user profile was created, in RFC 3339 format.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Details about the entity this profile represents, as the platform states them; not verified by Anthropic. Every field is present, `null` until the platform supplies a value. Absent under the legacy `user-profiles-2026-03-24` and `user-profiles-2026-08-18` beta headers, which serve `reference_id` as the top-level `external_id` and, under `user-profiles-2026-08-18`, `onboarded_at` as `external_user_onboarded_at`.
     *
     * @param UserProfileExternalUserDetails|UserProfileExternalUserDetailsShape $externalUserDetails
     */
    public function withExternalUserDetails(
        UserProfileExternalUserDetails|array $externalUserDetails
    ): self {
        $self = clone $this;
        $self['externalUserDetails'] = $externalUserDetails;

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
     * The profile's standing in each Anthropic program, such as the Cyber Verification Program. Present when the request sends no user-profiles beta header; absent under the `user-profiles-2026-09-04` and earlier beta headers, which serve `trust_grants` instead.
     *
     * @param UserProfilePrograms|UserProfileProgramsShape $programs
     */
    public function withPrograms(UserProfilePrograms|array $programs): self
    {
        $self = clone $this;
        $self['programs'] = $programs;

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
}
