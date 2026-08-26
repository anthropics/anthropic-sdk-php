<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ServiceAccounts;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountUpdateParams\OrganizationRole;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
 *
 * Update a service account.
 *
 * Only `description` and `organization_role` are mutable; `name` cannot be
 * changed. Archived service accounts cannot be updated; this returns 400.
 * Setting `organization_role` to `admin` (even when unchanged) requires an
 * interactive credential (a user OAuth token or a Console session).
 *
 * @see Anthropic\Services\Beta\Organization\ServiceAccountsService::update()
 *
 * @phpstan-type ServiceAccountUpdateParamsShape = array{
 *   description?: string|null,
 *   organizationRole?: null|OrganizationRole|value-of<OrganizationRole>,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class ServiceAccountUpdateParams implements BaseModel
{
    /** @use SdkModel<ServiceAccountUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Replaces the description. Omit to leave unchanged; send `null` to clear (the field is stored as an empty string).
     */
    #[Optional(nullable: true)]
    public ?string $description;

    /**
     * Replaces the org-level role. Omit or send `null` to leave unchanged.
     *
     * @var value-of<OrganizationRole>|null $organizationRole
     */
    #[Optional(
        'organization_role',
        enum: OrganizationRole::class,
        nullable: true
    )]
    public ?string $organizationRole;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param OrganizationRole|value-of<OrganizationRole>|null $organizationRole
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?string $description = null,
        OrganizationRole|string|null $organizationRole = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $description && $self['description'] = $description;
        null !== $organizationRole && $self['organizationRole'] = $organizationRole;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Replaces the description. Omit to leave unchanged; send `null` to clear (the field is stored as an empty string).
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Replaces the org-level role. Omit or send `null` to leave unchanged.
     *
     * @param OrganizationRole|value-of<OrganizationRole>|null $organizationRole
     */
    public function withOrganizationRole(
        OrganizationRole|string|null $organizationRole
    ): self {
        $self = clone $this;
        $self['organizationRole'] = $organizationRole;

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
}
