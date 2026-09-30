<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type AnalyticsUserActorShape = array{
 *   deleted: bool,
 *   emailAddress: string|null,
 *   name: string|null,
 *   type: 'user_actor',
 *   userID: string,
 * }
 */
final class AnalyticsUserActor implements BaseModel
{
    /** @use SdkModel<AnalyticsUserActorShape> */
    use SdkModel;

    /**
     * Actor type. Always `"user_actor"`.
     *
     * @var 'user_actor' $type
     */
    #[Required(type: new ConstantOf('user_actor'))]
    public string $type = 'user_actor';

    /**
     * True when the account has been deleted, or when the user is no longer a member of the organization or its associated organizations (for example, their membership was removed or they were deprovisioned via your identity provider). `email_address` stays populated for removed users and is null when the account has been deleted. `name` follows the rules described on that field. The `user_id` is still populated for reconciliation.
     */
    #[Required]
    public bool $deleted;

    /**
     * The user's email address, including for users who are no longer members of the organization or its associated organizations. Null when the account has been deleted (check `deleted`) and for system-minted service accounts, which have no person's mailbox behind them (check `name`).
     */
    #[Required('email_address')]
    public ?string $emailAddress;

    /**
     * The user's full name. Null when the user has not set a name. Returns `"Deleted User"` when the account itself has been deleted, or when the user is no longer a member of the organization or its associated organizations and the organization has chosen to hide the names of removed users. Otherwise, the name stays populated for removed users. Rows for system-minted service accounts render the service name (for example, `"Claude Security"` for usage by Anthropic's security-patching service) or null.
     */
    #[Required]
    public ?string $name;

    /**
     * Tagged user ID.
     */
    #[Required('user_id')]
    public string $userID;

    /**
     * `new AnalyticsUserActor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsUserActor::with(
     *   deleted: ..., emailAddress: ..., name: ..., userID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsUserActor)
     *   ->withDeleted(...)
     *   ->withEmailAddress(...)
     *   ->withName(...)
     *   ->withUserID(...)
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
     */
    public static function with(
        bool $deleted,
        ?string $emailAddress,
        ?string $name,
        string $userID
    ): self {
        $self = new self;

        $self['deleted'] = $deleted;
        $self['emailAddress'] = $emailAddress;
        $self['name'] = $name;
        $self['userID'] = $userID;

        return $self;
    }

    /**
     * True when the account has been deleted, or when the user is no longer a member of the organization or its associated organizations (for example, their membership was removed or they were deprovisioned via your identity provider). `email_address` stays populated for removed users and is null when the account has been deleted. `name` follows the rules described on that field. The `user_id` is still populated for reconciliation.
     */
    public function withDeleted(bool $deleted): self
    {
        $self = clone $this;
        $self['deleted'] = $deleted;

        return $self;
    }

    /**
     * The user's email address, including for users who are no longer members of the organization or its associated organizations. Null when the account has been deleted (check `deleted`) and for system-minted service accounts, which have no person's mailbox behind them (check `name`).
     */
    public function withEmailAddress(?string $emailAddress): self
    {
        $self = clone $this;
        $self['emailAddress'] = $emailAddress;

        return $self;
    }

    /**
     * The user's full name. Null when the user has not set a name. Returns `"Deleted User"` when the account itself has been deleted, or when the user is no longer a member of the organization or its associated organizations and the organization has chosen to hide the names of removed users. Otherwise, the name stays populated for removed users. Rows for system-minted service accounts render the service name (for example, `"Claude Security"` for usage by Anthropic's security-patching service) or null.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Actor type. Always `"user_actor"`.
     *
     * @param 'user_actor' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Tagged user ID.
     */
    public function withUserID(string $userID): self
    {
        $self = clone $this;
        $self['userID'] = $userID;

        return $self;
    }
}
