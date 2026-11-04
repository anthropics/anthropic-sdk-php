<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List Workspaces
 *
 * @see Anthropic\Services\Beta\Organization\WorkspacesService::list()
 *
 * @phpstan-type WorkspaceListParamsShape = array{
 *   afterID?: string|null,
 *   beforeID?: string|null,
 *   ids?: list<string>|null,
 *   includeArchived?: bool|null,
 *   includeDefault?: bool|null,
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
     * Only the Workspaces with these IDs, at most 100. `include_archived` and `include_default` still apply, and IDs of Workspaces the caller can't list are left out.
     *
     * @var list<string>|null $ids
     */
    #[Optional(list: 'string')]
    public ?array $ids;

    /**
     * Whether to include Workspaces that have been archived in the response
     */
    #[Optional]
    public ?bool $includeArchived;

    /**
     * Whether to include the organization's default Workspace in the response
     */
    #[Optional]
    public ?bool $includeDefault;

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
     *
     * @param list<string>|null $ids
     */
    public static function with(
        ?string $afterID = null,
        ?string $beforeID = null,
        ?array $ids = null,
        ?bool $includeArchived = null,
        ?bool $includeDefault = null,
        ?int $limit = null,
    ): self {
        $self = new self;

        null !== $afterID && $self['afterID'] = $afterID;
        null !== $beforeID && $self['beforeID'] = $beforeID;
        null !== $ids && $self['ids'] = $ids;
        null !== $includeArchived && $self['includeArchived'] = $includeArchived;
        null !== $includeDefault && $self['includeDefault'] = $includeDefault;
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
     * Only the Workspaces with these IDs, at most 100. `include_archived` and `include_default` still apply, and IDs of Workspaces the caller can't list are left out.
     *
     * @param list<string> $ids
     */
    public function withIDs(array $ids): self
    {
        $self = clone $this;
        $self['ids'] = $ids;

        return $self;
    }

    /**
     * Whether to include Workspaces that have been archived in the response
     */
    public function withIncludeArchived(bool $includeArchived): self
    {
        $self = clone $this;
        $self['includeArchived'] = $includeArchived;

        return $self;
    }

    /**
     * Whether to include the organization's default Workspace in the response
     */
    public function withIncludeDefault(bool $includeDefault): self
    {
        $self = clone $this;
        $self['includeDefault'] = $includeDefault;

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
