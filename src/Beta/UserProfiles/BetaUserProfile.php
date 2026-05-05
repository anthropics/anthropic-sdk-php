<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles;

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
 *   relationship: Relationship|value-of<Relationship>,
 *   trustGrants: array<string,BetaUserProfileTrustGrant|BetaUserProfileTrustGrantShape>,
 *   type: Type|value-of<Type>,
 *   updatedAt: \DateTimeInterface,
 *   externalID?: string|null,
 *   name?: string|null,
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
     * How the entity behind a user profile relates to the platform that owns the API key. `external`: an individual end-user of the platform. `resold`: a company the platform resells Claude access to. `internal`: the platform's own usage.
     *
     * @var value-of<Relationship> $relationship
     */
    #[Required(enum: Relationship::class)]
    public string $relationship;

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
     * Platform's own identifier for this user. Not enforced unique.
     */
    #[Optional('external_id', nullable: true)]
    public ?string $externalID;

    /**
     * Display name of the entity this profile represents. For `resold` this is the resold-to company's name.
     */
    #[Optional(nullable: true)]
    public ?string $name;

    /**
     * `new BetaUserProfile()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaUserProfile::with(
     *   id: ...,
     *   createdAt: ...,
     *   metadata: ...,
     *   relationship: ...,
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
     *   ->withRelationship(...)
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
     * @param Relationship|value-of<Relationship> $relationship
     * @param array<string,BetaUserProfileTrustGrant|BetaUserProfileTrustGrantShape> $trustGrants
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        array $metadata,
        Relationship|string $relationship,
        array $trustGrants,
        Type|string $type,
        \DateTimeInterface $updatedAt,
        ?string $externalID = null,
        ?string $name = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['metadata'] = $metadata;
        $self['relationship'] = $relationship;
        $self['trustGrants'] = $trustGrants;
        $self['type'] = $type;
        $self['updatedAt'] = $updatedAt;

        null !== $externalID && $self['externalID'] = $externalID;
        null !== $name && $self['name'] = $name;

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
     * Platform's own identifier for this user. Not enforced unique.
     */
    public function withExternalID(?string $externalID): self
    {
        $self = clone $this;
        $self['externalID'] = $externalID;

        return $self;
    }

    /**
     * Display name of the entity this profile represents. For `resold` this is the resold-to company's name.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
