<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles;

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
 *   externalID?: string|null,
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
     * Platform's own identifier for this user. Not enforced unique.
     */
    #[Optional('external_id', nullable: true)]
    public ?string $externalID;

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
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        array $metadata,
        array $trustGrants,
        Type|string $type,
        \DateTimeInterface $updatedAt,
        ?string $externalID = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['metadata'] = $metadata;
        $self['trustGrants'] = $trustGrants;
        $self['type'] = $type;
        $self['updatedAt'] = $updatedAt;

        null !== $externalID && $self['externalID'] = $externalID;

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
     * Platform's own identifier for this user. Not enforced unique.
     */
    public function withExternalID(?string $externalID): self
    {
        $self = clone $this;
        $self['externalID'] = $externalID;

        return $self;
    }
}
