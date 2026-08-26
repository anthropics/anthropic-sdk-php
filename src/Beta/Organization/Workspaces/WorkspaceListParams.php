<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List Workspaces.
 *
 * @see Anthropic\Services\Beta\Organization\WorkspacesService::list()
 *
 * @phpstan-type WorkspaceListParamsShape = array{
 *   afterID?: string|null,
 *   beforeID?: string|null,
 *   includeArchived?: bool|null,
 *   limit?: int|null,
 * }
 */
final class WorkspaceListParams implements BaseModel
{
    /** @use SdkModel<WorkspaceListParamsShape> */
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
     * Whether to include Workspaces that have been archived in the response.
     */
    #[Optional]
    public ?bool $includeArchived;

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
        ?bool $includeArchived = null,
        ?int $limit = null,
    ): self {
        $self = new self;

        null !== $afterID && $self['afterID'] = $afterID;
        null !== $beforeID && $self['beforeID'] = $beforeID;
        null !== $includeArchived && $self['includeArchived'] = $includeArchived;
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
     * Whether to include Workspaces that have been archived in the response.
     */
    public function withIncludeArchived(bool $includeArchived): self
    {
        $self = clone $this;
        $self['includeArchived'] = $includeArchived;

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
