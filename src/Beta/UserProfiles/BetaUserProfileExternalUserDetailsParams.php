<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles;

use Anthropic\Beta\UserProfiles\BetaUserProfileExternalUserDetailsParams\AccountStatus;
use Anthropic\Beta\UserProfiles\BetaUserProfileExternalUserDetailsParams\EntityType;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaUserProfileExternalUserDetailsParamsShape = array{
 *   accountStatus?: null|AccountStatus|value-of<AccountStatus>,
 *   country?: string|null,
 *   emailHash?: string|null,
 *   entityType?: null|EntityType|value-of<EntityType>,
 *   nameHash?: string|null,
 *   onboardedAt?: \DateTimeInterface|null,
 *   referenceID?: string|null,
 * }
 */
final class BetaUserProfileExternalUserDetailsParams implements BaseModel
{
    /** @use SdkModel<BetaUserProfileExternalUserDetailsParamsShape> */
    use SdkModel;

    /**
     * The status of the entity's account on the platform, as the platform states it: `active`; `suspended`, when the platform has restricted the account and may restore it; or `blocked`, when the platform has barred it. It records the platform's decision only; the statuses in `trust_grants` are Anthropic's and do not follow it.
     *
     * @var value-of<AccountStatus>|null $accountStatus
     */
    #[Optional('account_status', enum: AccountStatus::class, nullable: true)]
    public ?string $accountStatus;

    /**
     * The country of the entity (not of the platform), as the platform determines it: an ISO 3166-1 alpha-2 code in upper case, for example `US`. Only the form, two uppercase ASCII letters, is checked.
     */
    #[Optional(nullable: true)]
    public ?string $country;

    /**
     * A hash of the entity's email address, computed by the platform. Anthropic treats it as an opaque string and does not prescribe the hash function. 1 to 255 characters.
     */
    #[Optional('email_hash', nullable: true)]
    public ?string $emailHash;

    /**
     * What kind of entity the profile represents, as the platform states it: `individual`, `business`, `non_profit` or `government`.
     *
     * @var value-of<EntityType>|null $entityType
     */
    #[Optional('entity_type', enum: EntityType::class, nullable: true)]
    public ?string $entityType;

    /**
     * A hash of the entity's name, computed by the platform. Anthropic treats it as an opaque string and does not prescribe the hash function. 1 to 255 characters.
     */
    #[Optional('name_hash', nullable: true)]
    public ?string $nameHash;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Optional('onboarded_at')]
    public ?\DateTimeInterface $onboardedAt;

    /**
     * The platform's own reference for the entity, for example the key of the end-user's row in the platform's database. Not interpreted by Anthropic and not enforced unique. 1 to 255 characters.
     */
    #[Optional('reference_id', nullable: true)]
    public ?string $referenceID;

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
        AccountStatus|string|null $accountStatus = null,
        ?string $country = null,
        ?string $emailHash = null,
        EntityType|string|null $entityType = null,
        ?string $nameHash = null,
        ?\DateTimeInterface $onboardedAt = null,
        ?string $referenceID = null,
    ): self {
        $self = new self;

        null !== $accountStatus && $self['accountStatus'] = $accountStatus;
        null !== $country && $self['country'] = $country;
        null !== $emailHash && $self['emailHash'] = $emailHash;
        null !== $entityType && $self['entityType'] = $entityType;
        null !== $nameHash && $self['nameHash'] = $nameHash;
        null !== $onboardedAt && $self['onboardedAt'] = $onboardedAt;
        null !== $referenceID && $self['referenceID'] = $referenceID;

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
     * The country of the entity (not of the platform), as the platform determines it: an ISO 3166-1 alpha-2 code in upper case, for example `US`. Only the form, two uppercase ASCII letters, is checked.
     */
    public function withCountry(?string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    /**
     * A hash of the entity's email address, computed by the platform. Anthropic treats it as an opaque string and does not prescribe the hash function. 1 to 255 characters.
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
     * A hash of the entity's name, computed by the platform. Anthropic treats it as an opaque string and does not prescribe the hash function. 1 to 255 characters.
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
    public function withOnboardedAt(\DateTimeInterface $onboardedAt): self
    {
        $self = clone $this;
        $self['onboardedAt'] = $onboardedAt;

        return $self;
    }

    /**
     * The platform's own reference for the entity, for example the key of the end-user's row in the platform's database. Not interpreted by Anthropic and not enforced unique. 1 to 255 characters.
     */
    public function withReferenceID(?string $referenceID): self
    {
        $self = clone $this;
        $self['referenceID'] = $referenceID;

        return $self;
    }
}
