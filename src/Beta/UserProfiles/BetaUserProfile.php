<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles;

use Anthropic\Beta\UserProfiles\BetaUserProfile\AccessType;
use Anthropic\Beta\UserProfiles\BetaUserProfile\Relationship;
use Anthropic\Beta\UserProfiles\BetaUserProfile\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaUserProfileTrustGrantShape from \Anthropic\Beta\UserProfiles\BetaUserProfileTrustGrant
 *
 * @phpstan-type BetaUserProfileShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   metadata: array<string,string>,
 *   trustGrants: array<string,BetaUserProfileTrustGrant|BetaUserProfileTrustGrantShape>,
 *   type: Type|value-of<Type>,
 *   updatedAt: \DateTimeInterface,
 *   accessType?: null|AccessType|value-of<AccessType>,
 *   externalID?: string|null,
 *   name?: string|null,
 *   relationship?: null|Relationship|value-of<Relationship>,
 * }
 */
final class BetaUserProfile implements BaseModel
{
    /** @use SdkModel<BetaUserProfileShape> */
    use SdkModel;

    /**
     * Unique identifier for this user profile, prefixed `uprof_`.
     */
    #[Required]
    public string $id;

    /**
     * A timestamp in RFC 3339 format.
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
     * Trust grants for this profile, keyed by grant name. Key omitted when no grant is active or in flight.
     *
     * @var array<string,BetaUserProfileTrustGrant> $trustGrants
     */
    #[Required('trust_grants', map: BetaUserProfileTrustGrant::class)]
    public array $trustGrants;

    /**
     * Object type. Always `user_profile`.
     *
     * @var value-of<Type> $type
     */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * How the platform uses the API on behalf of the entity this profile represents. `application`: the platform sells a product that uses the API behind the scenes, and the profile represents an individual end-user of that product. `passthrough`: the platform resells raw inference, and the profile identifies the resold-to company.
     *
     * @var value-of<AccessType>|null $accessType
     */
    #[Optional('access_type', enum: AccessType::class)]
    public ?string $accessType;

    /**
     * Platform's own identifier for this user. Not enforced unique.
     */
    #[Optional('external_id', nullable: true)]
    public ?string $externalID;

    /**
     * Real-world name of the entity this profile represents (company or individual). For a resold-to company (`access_type` `passthrough`, or `relationship` `resold` under the `user-profiles-2026-03-24` header) this is that company's name.
     */
    #[Optional(nullable: true)]
    public ?string $name;

    /**
     * How the entity behind a user profile relates to the platform that owns the API key. `external`: an individual end-user of the platform. `resold`: a company the platform resells Claude access to. `internal`: the platform's own usage.
     *
     * @var value-of<Relationship>|null $relationship
     */
    #[Optional(enum: Relationship::class)]
    public ?string $relationship;

    /**
     * `new BetaUserProfile()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaUserProfile::with(
     *   id: ...,
     *   createdAt: ...,
     *   metadata: ...,
     *   trustGrants: ...,
     *   type: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaUserProfile)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withMetadata(...)
     *   ->withTrustGrants(...)
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
     *
     * @param array<string,string> $metadata
     * @param array<string,BetaUserProfileTrustGrant|BetaUserProfileTrustGrantShape> $trustGrants
     * @param Type|value-of<Type> $type
     * @param AccessType|value-of<AccessType>|null $accessType
     * @param Relationship|value-of<Relationship>|null $relationship
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        array $metadata,
        array $trustGrants,
        Type|string $type,
        \DateTimeInterface $updatedAt,
        AccessType|string|null $accessType = null,
        ?string $externalID = null,
        ?string $name = null,
        Relationship|string|null $relationship = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['metadata'] = $metadata;
        $self['trustGrants'] = $trustGrants;
        $self['type'] = $type;
        $self['updatedAt'] = $updatedAt;

        null !== $accessType && $self['accessType'] = $accessType;
        null !== $externalID && $self['externalID'] = $externalID;
        null !== $name && $self['name'] = $name;
        null !== $relationship && $self['relationship'] = $relationship;

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
     * A timestamp in RFC 3339 format.
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
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

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
     * Platform's own identifier for this user. Not enforced unique.
     */
    public function withExternalID(?string $externalID): self
    {
        $self = clone $this;
        $self['externalID'] = $externalID;

        return $self;
    }

    /**
     * Real-world name of the entity this profile represents (company or individual). For a resold-to company (`access_type` `passthrough`, or `relationship` `resold` under the `user-profiles-2026-03-24` header) this is that company's name.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * How the entity behind a user profile relates to the platform that owns the API key. `external`: an individual end-user of the platform. `resold`: a company the platform resells Claude access to. `internal`: the platform's own usage.
     *
     * @param Relationship|value-of<Relationship> $relationship
     */
    public function withRelationship(Relationship|string $relationship): self
    {
        $self = clone $this;
        $self['relationship'] = $relationship;

        return $self;
    }
}
