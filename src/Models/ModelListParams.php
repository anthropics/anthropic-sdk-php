<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Models\AnthropicBeta\UnionMember1;

/**
 * List available models.
 *
 * The Models API response can be used to determine which models are available for use in the API. More recently released models are listed first.
 *
 * @phpstan-type list_params = array{
 *   afterID?: string,
 *   beforeID?: string,
 *   limit?: int,
 *   anthropicBeta?: list<string|UnionMember1::*>,
 * }
 */
final class ModelListParams implements BaseModel
{
    use ModelTrait;
    use Params;

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
     * @var null|list<string|UnionMember1::*> $anthropicBeta
     */
    #[Api(type: new ListOf(union: AnthropicBeta::class), optional: true)]
    public ?array $anthropicBeta;

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
     * @param null|list<string|UnionMember1::*> $anthropicBeta
     */
    public static function new(
        ?string $afterID = null,
        ?string $beforeID = null,
        ?int $limit = null,
        ?array $anthropicBeta = null,
    ): self {
        $obj = new self;

        null !== $afterID && $obj->afterID = $afterID;
        null !== $beforeID && $obj->beforeID = $beforeID;
        null !== $limit && $obj->limit = $limit;
        null !== $anthropicBeta && $obj->anthropicBeta = $anthropicBeta;

        return $obj;
    }
}
