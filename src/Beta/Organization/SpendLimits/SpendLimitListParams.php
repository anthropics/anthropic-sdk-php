<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitListParams\ScopeType;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List the organization's spend limits.
 *
 * A Claude Console organization's limits come in an order that is stable across
 * pages. A Claude Enterprise organization's are grouped by scope type,
 * in the order `organization`, `seat_tier`, `rbac_group`,
 * `organization_service`, `user`; within a type they come in a fixed order that
 * is not creation order.
 *
 * @see Anthropic\Services\Beta\Organization\SpendLimitsService::list()
 *
 * @phpstan-type SpendLimitListParamsShape = array{
 *   limit?: int|null,
 *   page?: string|null,
 *   scopeType?: list<ScopeType|value-of<ScopeType>>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class SpendLimitListParams implements BaseModel
{
    /** @use SdkModel<SpendLimitListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Maximum number of limits per page. Defaults to `20`.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Opaque cursor from a previous response's `next_page` field.
     */
    #[Optional(nullable: true)]
    public ?string $page;

    /**
     * Return only limits with these scope types. A Claude Console organization has `organization` and `workspace` limits; a Claude Enterprise organization has `organization`, `seat_tier`, `rbac_group`, `organization_service` and `user` limits. Omit for all.
     *
     * @var list<value-of<ScopeType>>|null $scopeType
     */
    #[Optional(list: ScopeType::class, nullable: true)]
    public ?array $scopeType;

    /**
     * This endpoint is in beta: requests must send `spend-limit-reads-2026-09-26` in this header.
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
     * @param list<ScopeType|value-of<ScopeType>>|null $scopeType
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?int $limit = null,
        ?string $page = null,
        ?array $scopeType = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;
        null !== $scopeType && $self['scopeType'] = $scopeType;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Maximum number of limits per page. Defaults to `20`.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Opaque cursor from a previous response's `next_page` field.
     */
    public function withPage(?string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Return only limits with these scope types. A Claude Console organization has `organization` and `workspace` limits; a Claude Enterprise organization has `organization`, `seat_tier`, `rbac_group`, `organization_service` and `user` limits. Omit for all.
     *
     * @param list<ScopeType|value-of<ScopeType>>|null $scopeType
     */
    public function withScopeType(?array $scopeType): self
    {
        $self = clone $this;
        $self['scopeType'] = $scopeType;

        return $self;
    }

    /**
     * This endpoint is in beta: requests must send `spend-limit-reads-2026-09-26` in this header.
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
