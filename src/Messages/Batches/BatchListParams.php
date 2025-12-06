<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List all Message Batches within a Workspace. Most recently created batches are returned first.
 *
 * Learn more about the Message Batches API in our [user guide](https://docs.claude.com/en/docs/build-with-claude/batch-processing)
 *
 * @see Anthropic\Services\Messages\BatchesService::list()
 *
 * @phpstan-type BatchListParamsShape = array{
 *   after_id?: string, before_id?: string, limit?: int
 * }
 */
final class BatchListParams implements BaseModel
{
    /** @use SdkModel<BatchListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     */
    #[Api(optional: true)]
    public ?string $after_id;

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     */
    #[Api(optional: true)]
    public ?string $before_id;

    /**
     * Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     */
    #[Api(optional: true)]
    public ?int $limit;

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
        ?string $after_id = null,
        ?string $before_id = null,
        ?int $limit = null
    ): self {
        $obj = new self;

        null !== $after_id && $obj['after_id'] = $after_id;
        null !== $before_id && $obj['before_id'] = $before_id;
        null !== $limit && $obj['limit'] = $limit;

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
}
