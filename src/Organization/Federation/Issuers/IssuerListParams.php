<?php

declare(strict_types=1);

namespace Anthropic\Organization\Federation\Issuers;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
 *
 * List federation issuers in your organization.
 *
 * Archived issuers are excluded unless `include_archived=true`.
 *
 * @see Anthropic\Services\Organization\Federation\IssuersService::list()
 *
 * @phpstan-type IssuerListParamsShape = array{
 *   includeArchived?: bool|null, limit?: int|null, page?: string|null
 * }
 */
final class IssuerListParams implements BaseModel
{
    /** @use SdkModel<IssuerListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Include archived resources. Defaults to false.
     */
    #[Optional]
    public ?bool $includeArchived;

    /**
     * Number of results per page.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Opaque cursor from a previous response's `next_page`.
     */
    #[Optional(nullable: true)]
    public ?string $page;

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
        ?bool $includeArchived = null,
        ?int $limit = null,
        ?string $page = null
    ): self {
        $self = new self;

        null !== $includeArchived && $self['includeArchived'] = $includeArchived;
        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;

        return $self;
    }

    /**
     * Include archived resources. Defaults to false.
     */
    public function withIncludeArchived(bool $includeArchived): self
    {
        $self = clone $this;
        $self['includeArchived'] = $includeArchived;

        return $self;
    }

    /**
     * Number of results per page.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Opaque cursor from a previous response's `next_page`.
     */
    public function withPage(?string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }
}
