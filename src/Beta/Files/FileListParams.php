<?php

declare(strict_types=1);

namespace Anthropic\Beta\Files;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List Files.
 *
 * @see Anthropic\Beta\Files->list
 *
 * @phpstan-type file_list_params = array{
 *   afterID?: string,
 *   beforeID?: string,
 *   limit?: int,
 *   betas?: list<AnthropicBeta::*|string>,
 * }
 */
final class FileListParams implements BaseModel
{
    /** @use SdkModel<file_list_params> */
    use SdkModel;
    use SdkParams;

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     */
    #[Api(optional: true)]
    public ?string $afterID;

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     */
    #[Api(optional: true)]
    public ?string $beforeID;

    /**
     * Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     */
    #[Api(optional: true)]
    public ?int $limit;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<AnthropicBeta::*|string>|null $betas
     */
    #[Api(list: AnthropicBeta::class, optional: true)]
    public ?array $betas;

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<AnthropicBeta::*|string> $betas
     */
    public static function with(
        ?string $afterID = null,
        ?string $beforeID = null,
        ?int $limit = null,
        ?array $betas = null,
    ): self {
        $obj = new self;

        null !== $afterID && $obj->afterID = $afterID;
        null !== $beforeID && $obj->beforeID = $beforeID;
        null !== $limit && $obj->limit = $limit;
        null !== $betas && $obj->betas = $betas;

        return $obj;
    }

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     */
    public function withAfterID(string $afterID): self
    {
        $obj = clone $this;
        $obj->afterID = $afterID;

        return $obj;
    }

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     */
    public function withBeforeID(string $beforeID): self
    {
        $obj = clone $this;
        $obj->beforeID = $beforeID;

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
        $obj->limit = $limit;

        return $obj;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<AnthropicBeta::*|string> $betas
     */
    public function withBetas(array $betas): self
    {
        $obj = clone $this;
        $obj->betas = $betas;

        return $obj;
    }
}
