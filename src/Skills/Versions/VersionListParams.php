<?php

declare(strict_types=1);

namespace Anthropic\Skills\Versions;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List Skill Versions.
 *
 * @see Anthropic\Services\Skills\VersionsService::list()
 *
 * @phpstan-type VersionListParamsShape = array{
 *   limit?: int|null, page?: string|null
 * }
 */
final class VersionListParams implements BaseModel
{
    /** @use SdkModel<VersionListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Number of results to return per page.
     *
     * Ranges from `1` to `1000`. Defaults to `20`.
     */
    #[Optional(nullable: true)]
    public ?int $limit;

    /**
     * Optionally set to the `next_page` token from the previous response.
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
     * Number of results to return per page.
     *
     * Ranges from `1` to `1000`. Defaults to `20`.
     */
    public function withLimit(?int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Optionally set to the `next_page` token from the previous response.
     */
    public function withPage(?string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }
}
