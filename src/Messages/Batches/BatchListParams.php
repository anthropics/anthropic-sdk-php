<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches;

use Anthropic\Core\Attributes\Optional;
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
 *   afterID?: string|null, beforeID?: string|null, limit?: int|null
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
    #[Optional]
    public ?string $afterID;

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     */
    #[Optional]
    public ?string $beforeID;

    /**
     * Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     */
    #[Optional]
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
        ?string $afterID = null,
        ?string $beforeID = null,
        ?int $limit = null
    ): self {
        $self = new self;

        null !== $afterID && $self['afterID'] = $afterID;
        null !== $beforeID && $self['beforeID'] = $beforeID;
        null !== $limit && $self['limit'] = $limit;

        return $self;
    }

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     */
    public function withAfterID(string $afterID): self
    {
        $self = clone $this;
        $self['afterID'] = $afterID;

        return $self;
    }

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     */
    public function withBeforeID(string $beforeID): self
    {
        $self = clone $this;
        $self['beforeID'] = $beforeID;

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
}
