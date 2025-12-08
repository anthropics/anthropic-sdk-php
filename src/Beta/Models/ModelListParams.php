<?php

declare(strict_types=1);

namespace Anthropic\Beta\Models;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List available models.
 *
 * The Models API response can be used to determine which models are available for use in the API. More recently released models are listed first.
 *
 * @see Anthropic\Services\Beta\ModelsService::list()
 *
 * @phpstan-type ModelListParamsShape = array{
 *   after_id?: string,
 *   before_id?: string,
 *   limit?: int,
 *   betas?: list<string|AnthropicBeta>,
 * }
 */
final class ModelListParams implements BaseModel
{
    /** @use SdkModel<ModelListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     */
    #[Optional]
    public ?string $after_id;

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     */
    #[Optional]
    public ?string $before_id;

    /**
     * Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     */
    #[Optional]
    public ?int $limit;

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
     * @param list<string|AnthropicBeta> $betas
     */
    public static function with(
        ?string $after_id = null,
        ?string $before_id = null,
        ?int $limit = null,
        ?array $betas = null,
    ): self {
        $obj = new self;

        null !== $after_id && $obj['after_id'] = $after_id;
        null !== $before_id && $obj['before_id'] = $before_id;
        null !== $limit && $obj['limit'] = $limit;
        null !== $betas && $obj['betas'] = $betas;

        return $obj;
    }

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     */
    public function withAfterID(string $afterID): self
    {
        $obj = clone $this;
        $obj['after_id'] = $afterID;

        return $obj;
    }

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     */
    public function withBeforeID(string $beforeID): self
    {
        $obj = clone $this;
        $obj['before_id'] = $beforeID;

        return $obj;
    }

    /**
     * Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     */
    public function withLimit(int $limit): self
    {
        $obj = clone $this;
        $obj['limit'] = $limit;

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
