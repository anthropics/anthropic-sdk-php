<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles;

use Anthropic\Beta\UserProfiles\BetaUserProfileExternalUserDetails\AccountStatus;
use Anthropic\Beta\UserProfiles\BetaUserProfileExternalUserDetails\EntityType;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Details about the entity this profile represents, as the platform states them. Anthropic does not verify them. Every field is present, `null` until the platform supplies a value.
 *
 * @phpstan-type BetaUserProfileExternalUserDetailsShape = array{
 *   accountStatus: null|AccountStatus|value-of<AccountStatus>,
 *   country: string|null,
 *   emailHash: string|null,
 *   entityType: null|EntityType|value-of<EntityType>,
 *   nameHash: string|null,
 *   onboardedAt: \DateTimeInterface|null,
 *   referenceID: string|null,
 * }
 */
final class BetaUserProfileExternalUserDetails implements BaseModel
{
    /** @use SdkModel<BetaUserProfileExternalUserDetailsShape> */
    use SdkModel;

    /**
     * The status of the entity's account on the platform, as the platform states it: `active`; `suspended`, when the platform has restricted the account and may restore it; or `blocked`, when the platform has barred it. It records the platform's decision only; the statuses in `trust_grants` are Anthropic's and do not follow it.
     *
     * @var value-of<AccountStatus>|null $accountStatus
     */
    #[Required('account_status', enum: AccountStatus::class)]
    public ?string $accountStatus;

    /**
     * The country the platform associates with the entity, as an ISO 3166-1 alpha-2 code. `null` until the platform supplies one.
     */
    #[Required]
    public ?string $country;

    /**
     * The platform-computed hash of the entity's email address. `null` until the platform supplies one.
     */
    #[Required('email_hash')]
    public ?string $emailHash;

    /**
     * What kind of entity the profile represents, as the platform states it: `individual`, `business`, `non_profit` or `government`.
     *
     * @var value-of<EntityType>|null $entityType
     */
    #[Required('entity_type', enum: EntityType::class)]
    public ?string $entityType;

    /**
     * The platform-computed hash of the entity's name. `null` until the platform supplies one.
     */
    #[Required('name_hash')]
    public ?string $nameHash;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('onboarded_at')]
    public ?\DateTimeInterface $onboardedAt;

    /**
     * The platform's own reference for the entity. `null` until the platform supplies one.
     */
    #[Required('reference_id')]
    public ?string $referenceID;

    /**
     * `new BetaUserProfileExternalUserDetails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaUserProfileExternalUserDetails::with(
     *   accountStatus: ...,
     *   country: ...,
     *   emailHash: ...,
     *   entityType: ...,
     *   nameHash: ...,
     *   onboardedAt: ...,
     *   referenceID: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaUserProfileExternalUserDetails)
     *   ->withAccountStatus(...)
     *   ->withCountry(...)
     *   ->withEmailHash(...)
     *   ->withEntityType(...)
     *   ->withNameHash(...)
     *   ->withOnboardedAt(...)
     *   ->withReferenceID(...)
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
     * @param AccountStatus|value-of<AccountStatus>|null $accountStatus
     * @param EntityType|value-of<EntityType>|null $entityType
     */
    public static function with(
        AccountStatus|string|null $accountStatus,
        ?string $country,
        ?string $emailHash,
        EntityType|string|null $entityType,
        ?string $nameHash,
        ?\DateTimeInterface $onboardedAt,
        ?string $referenceID,
    ): self {
        $self = new self;

        $self['accountStatus'] = $accountStatus;
        $self['country'] = $country;
        $self['emailHash'] = $emailHash;
        $self['entityType'] = $entityType;
        $self['nameHash'] = $nameHash;
        $self['onboardedAt'] = $onboardedAt;
        $self['referenceID'] = $referenceID;

        return $self;
    }

    /**
     * The status of the entity's account on the platform, as the platform states it: `active`; `suspended`, when the platform has restricted the account and may restore it; or `blocked`, when the platform has barred it. It records the platform's decision only; the statuses in `trust_grants` are Anthropic's and do not follow it.
     *
     * @param AccountStatus|value-of<AccountStatus>|null $accountStatus
     */
    public function withAccountStatus(
        AccountStatus|string|null $accountStatus
    ): self {
        $self = clone $this;
        $self['accountStatus'] = $accountStatus;

        return $self;
    }

    /**
     * The country the platform associates with the entity, as an ISO 3166-1 alpha-2 code. `null` until the platform supplies one.
     */
    public function withCountry(?string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    /**
     * The platform-computed hash of the entity's email address. `null` until the platform supplies one.
     */
    public function withEmailHash(?string $emailHash): self
    {
        $self = clone $this;
        $self['emailHash'] = $emailHash;

        return $self;
    }

    /**
     * What kind of entity the profile represents, as the platform states it: `individual`, `business`, `non_profit` or `government`.
     *
     * @param EntityType|value-of<EntityType>|null $entityType
     */
    public function withEntityType(EntityType|string|null $entityType): self
    {
        $self = clone $this;
        $self['entityType'] = $entityType;

        return $self;
    }

    /**
     * The platform-computed hash of the entity's name. `null` until the platform supplies one.
     */
    public function withNameHash(?string $nameHash): self
    {
        $self = clone $this;
        $self['nameHash'] = $nameHash;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withOnboardedAt(?\DateTimeInterface $onboardedAt): self
    {
        $self = clone $this;
        $self['onboardedAt'] = $onboardedAt;

        return $self;
    }

    /**
     * The platform's own reference for the entity. `null` until the platform supplies one.
     */
    public function withReferenceID(?string $referenceID): self
    {
        $self = clone $this;
        $self['referenceID'] = $referenceID;

        return $self;
    }
}
