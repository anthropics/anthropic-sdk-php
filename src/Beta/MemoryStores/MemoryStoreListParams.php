<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List memory stores.
 *
 * @see Anthropic\Services\Beta\MemoryStoresService::list()
 *
 * @phpstan-type MemoryStoreListParamsShape = array{
 *   createdAtGte?: \DateTimeInterface|null,
 *   createdAtLte?: \DateTimeInterface|null,
 *   includeArchived?: bool|null,
 *   limit?: int|null,
 *   page?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class MemoryStoreListParams implements BaseModel
{
    /** @use SdkModel<MemoryStoreListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Return only stores whose `created_at` is at or after this time (inclusive). Sent on the wire as `created_at[gte]`.
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtGte;

    /**
     * Return only stores whose `created_at` is at or before this time (inclusive). Sent on the wire as `created_at[lte]`.
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtLte;

    /**
     * When `true`, archived stores are included in the results. Defaults to `false` (archived stores are excluded).
     */
    #[Optional]
    public ?bool $includeArchived;

    /**
     * Maximum number of stores to return per page. Must be between 1 and 100. Defaults to 20 when omitted.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Opaque pagination cursor (a `page_...` value). Pass the `next_page` value from a previous response to fetch the next page; omit for the first page.
     */
    #[Optional]
    public ?string $page;

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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?\DateTimeInterface $createdAtGte = null,
        ?\DateTimeInterface $createdAtLte = null,
        ?bool $includeArchived = null,
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $createdAtGte && $self['createdAtGte'] = $createdAtGte;
        null !== $createdAtLte && $self['createdAtLte'] = $createdAtLte;
        null !== $includeArchived && $self['includeArchived'] = $includeArchived;
        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Return only stores whose `created_at` is at or after this time (inclusive). Sent on the wire as `created_at[gte]`.
     */
    public function withCreatedAtGte(\DateTimeInterface $createdAtGte): self
    {
        $self = clone $this;
        $self['createdAtGte'] = $createdAtGte;

        return $self;
    }

    /**
     * Return only stores whose `created_at` is at or before this time (inclusive). Sent on the wire as `created_at[lte]`.
     */
    public function withCreatedAtLte(\DateTimeInterface $createdAtLte): self
    {
        $self = clone $this;
        $self['createdAtLte'] = $createdAtLte;

        return $self;
    }

    /**
     * When `true`, archived stores are included in the results. Defaults to `false` (archived stores are excluded).
     */
    public function withIncludeArchived(bool $includeArchived): self
    {
        $self = clone $this;
        $self['includeArchived'] = $includeArchived;

        return $self;
    }

    /**
     * Maximum number of stores to return per page. Must be between 1 and 100. Defaults to 20 when omitted.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Opaque pagination cursor (a `page_...` value). Pass the `next_page` value from a previous response to fetch the next page; omit for the first page.
     */
    public function withPage(string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

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
