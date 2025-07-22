<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Models\AnthropicBeta;
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
final class ModelListParam implements BaseModel
{
    use Model;
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

    /**
     * You must use named parameters to construct this object.
     *
     * @param null|list<string|UnionMember1::*> $anthropicBeta
     */
    final public function __construct(
        ?string $afterID = null,
        ?string $beforeID = null,
        ?int $limit = null,
        ?array $anthropicBeta = null,
    ) {
        self::introspect();
        $this->unsetOptionalProperties();

        null !== $afterID && $this->afterID = $afterID;
        null !== $beforeID && $this->beforeID = $beforeID;
        null !== $limit && $this->limit = $limit;
        null !== $anthropicBeta && $this->anthropicBeta = $anthropicBeta;
    }
}
