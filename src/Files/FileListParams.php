<?php

declare(strict_types=1);

namespace Anthropic\Files;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List Files.
 *
 * @see Anthropic\Services\FilesService::list()
 *
 * @phpstan-type FileListParamsShape = array{
 *   ids?: list<string>|null, limit?: int|null, page?: string|null
 * }
 */
final class FileListParams implements BaseModel
{
    /** @use SdkModel<FileListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Restrict the result set to Files whose `id` is in this list. At most 100 entries (after de-duplication). Mutually exclusive with `page` and `limit`. When supplied, the response is always a single page (`next_page` is null). IDs that do not resolve to a visible File — including deleted Files — are silently omitted.
     *
     * @var list<string>|null $ids
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $ids;

    /**
     * Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Opaque page cursor returned in a prior list response's `next_page`. Prefixed `page_`.
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
     *
     * @param list<string>|null $ids
     */
    public static function with(
        ?array $ids = null,
        ?int $limit = null,
        ?string $page = null
    ): self {
        $self = new self;

        null !== $ids && $self['ids'] = $ids;
        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;

        return $self;
    }

    /**
     * Restrict the result set to Files whose `id` is in this list. At most 100 entries (after de-duplication). Mutually exclusive with `page` and `limit`. When supplied, the response is always a single page (`next_page` is null). IDs that do not resolve to a visible File — including deleted Files — are silently omitted.
     *
     * @param list<string>|null $ids
     */
    public function withIDs(?array $ids): self
    {
        $self = clone $this;
        $self['ids'] = $ids;

        return $self;
    }

    /**
     * Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Opaque page cursor returned in a prior list response's `next_page`. Prefixed `page_`.
     */
    public function withPage(?string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }
}
