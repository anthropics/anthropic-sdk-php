<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ServiceAccounts;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountCreateParams\OrganizationRole;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
 *
 * Create a service account.
 *
 * A service account is a named workload identity that federation rules
 * target. `organization_role` is `developer` (default) or `admin`; a rule
 * may only be created or retargeted to grant `org:admin` scope when the
 * target's `organization_role` is `admin`. Creating an `admin`-role service
 * account requires an interactive credential (a user OAuth token or a
 * Console session) — a workload may only create `developer`-role service
 * accounts.
 *
 * @see Anthropic\Services\Beta\Organization\ServiceAccountsService::create()
 *
 * @phpstan-type ServiceAccountCreateParamsShape = array{
 *   name: string,
 *   description?: string|null,
 *   organizationRole?: null|OrganizationRole|value-of<OrganizationRole>,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class ServiceAccountCreateParams implements BaseModel
{
    /** @use SdkModel<ServiceAccountCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Slug identifier (lowercase, digits, hyphens). Unique within the organization; a duplicate name returns 409.
     */
    #[Required]
    public string $name;

    /**
     * Optional free-text description.
     */
    #[Optional(nullable: true)]
    public ?string $description;

    /**
     * Org-level role. Defaults to `developer`.
     *
     * @var value-of<OrganizationRole>|null $organizationRole
     */
    #[Optional('organization_role', enum: OrganizationRole::class)]
    public ?string $organizationRole;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new ServiceAccountCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ServiceAccountCreateParams::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ServiceAccountCreateParams)->withName(...)
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
     * @param OrganizationRole|value-of<OrganizationRole>|null $organizationRole
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        string $name,
        ?string $description = null,
        OrganizationRole|string|null $organizationRole = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['name'] = $name;

        null !== $description && $self['description'] = $description;
        null !== $organizationRole && $self['organizationRole'] = $organizationRole;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Slug identifier (lowercase, digits, hyphens). Unique within the organization; a duplicate name returns 409.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Optional free-text description.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Org-level role. Defaults to `developer`.
     *
     * @param OrganizationRole|value-of<OrganizationRole> $organizationRole
     */
    public function withOrganizationRole(
        OrganizationRole|string $organizationRole
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
