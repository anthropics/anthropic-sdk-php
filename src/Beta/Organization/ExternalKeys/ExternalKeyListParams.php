<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalKeys;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List external key configs in the caller's organization.
 *
 * Results are ordered by creation time (newest first). Use the
 * `next_page` cursor from the response to fetch subsequent pages.
 *
 * @see Anthropic\Services\Beta\Organization\ExternalKeysService::list()
 *
 * @phpstan-type ExternalKeyListParamsShape = array{
 *   limit?: int|null, page?: string|null
 * }
 */
final class ExternalKeyListParams implements BaseModel
{
    /** @use SdkModel<ExternalKeyListParamsShape> */
    use SdkModel;
    use SdkParams;

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
    public static function with(?int $limit = null, ?string $page = null): self
    {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;

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
