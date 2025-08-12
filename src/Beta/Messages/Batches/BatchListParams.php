<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\AnthropicBeta\UnionMember1;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;

/**
 * List all Message Batches within a Workspace. Most recently created batches are returned first.
 *
 * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
 *
 * @phpstan-type list_params = array{
 *   afterID?: string,
 *   beforeID?: string,
 *   limit?: int,
 *   anthropicBeta?: list<string|UnionMember1::*>,
 * }
 */
final class BatchListParams implements BaseModel
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
    public static function from(
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

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     */
    public function setAfterID(string $afterID): self
    {
        $this->afterID = $afterID;

        return $this;
    }

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     */
    public function setBeforeID(string $beforeID): self
    {
        $this->beforeID = $beforeID;

        return $this;
    }

    /**
     * Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     */
    public function setLimit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|UnionMember1::*> $betas
     */
    public function setBetas(array $betas): self
    {
        $this->anthropicBeta = $betas;

        return $this;
    }
}
