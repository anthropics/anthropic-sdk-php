<?php

declare(strict_types=1);

namespace Anthropic\Beta\Skills;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List Skills.
 *
 * @see Anthropic\Services\Beta\SkillsService::list()
 *
 * @phpstan-type SkillListParamsShape = array{
 *   limit?: int,
 *   page?: string|null,
 *   source?: string|null,
 *   betas?: list<string|AnthropicBeta>,
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
     * Maximum value is 100. Defaults to 20.
     */
    #[Api(optional: true)]
    public ?int $limit;

    /**
     * Pagination token for fetching a specific page of results.
     *
     * Pass the value from a previous response's `next_page` field to get the next page of results.
     */
    #[Api(nullable: true, optional: true)]
    public ?string $page;

    /**
     * Filter skills by source.
     *
     * If provided, only skills from the specified source will be returned:
     * * `"custom"`: only return user-created skills
     * * `"anthropic"`: only return Anthropic-created skills
     */
    #[Api(nullable: true, optional: true)]
    public ?string $source;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Api(list: AnthropicBeta::class, optional: true)]
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
     * @param list<string|AnthropicBeta> $betas
     */
    public static function with(
        ?int $limit = null,
        ?string $page = null,
        ?string $source = null,
        ?array $betas = null,
    ): self {
        $obj = new self;

        null !== $limit && $obj['limit'] = $limit;
        null !== $page && $obj['page'] = $page;
        null !== $source && $obj['source'] = $source;
        null !== $betas && $obj['betas'] = $betas;

        return $obj;
    }

    /**
     * Number of results to return per page.
     *
     * Maximum value is 100. Defaults to 20.
     */
    public function withLimit(int $limit): self
    {
        $obj = clone $this;
        $obj['limit'] = $limit;

        return $obj;
    }

    /**
     * Pagination token for fetching a specific page of results.
     *
     * Pass the value from a previous response's `next_page` field to get the next page of results.
     */
    public function withPage(?string $page): self
    {
        $obj = clone $this;
        $obj['page'] = $page;

        return $obj;
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
        $obj = clone $this;
        $obj['source'] = $source;

        return $obj;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta> $betas
     */
    public function withBetas(array $betas): self
    {
        $obj = clone $this;
        $obj['betas'] = $betas;

        return $obj;
    }
}
