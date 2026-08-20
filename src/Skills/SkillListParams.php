<?php

declare(strict_types=1);

namespace Anthropic\Skills;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List Skills.
 *
 * @see Anthropic\Services\SkillsService::list()
 *
 * @phpstan-type SkillListParamsShape = array{
 *   limit?: int|null, page?: string|null, source?: string|null
 * }
 */
final class SkillListParams implements BaseModel
{
    /** @use SdkModel<SkillListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Number of results to return per page.
     *
     * Ranges from `1` to `1000`. Defaults to `20`.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Pagination token for fetching a specific page of results.
     *
     * Pass the value from a previous response's `next_page` field to get the next page of results.
     */
    #[Optional(nullable: true)]
    public ?string $page;

    /**
     * Filter skills by source.
     *
     * If provided, only skills from the specified source will be returned:
     * * `"custom"`: only return user-created skills
     * * `"anthropic"`: only return Anthropic-created skills
     */
    #[Optional(nullable: true)]
    public ?string $source;

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
        ?int $limit = null,
        ?string $page = null,
        ?string $source = null
    ): self {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;
        null !== $source && $self['source'] = $source;

        return $self;
    }

    /**
     * Number of results to return per page.
     *
     * Ranges from `1` to `1000`. Defaults to `20`.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Pagination token for fetching a specific page of results.
     *
     * Pass the value from a previous response's `next_page` field to get the next page of results.
     */
    public function withPage(?string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Filter skills by source.
     *
     * If provided, only skills from the specified source will be returned:
     * * `"custom"`: only return user-created skills
     * * `"anthropic"`: only return Anthropic-created skills
     */
    public function withSource(?string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }
}
