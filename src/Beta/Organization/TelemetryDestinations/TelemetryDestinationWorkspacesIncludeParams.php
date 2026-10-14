<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Cover only the workspaces on the list.
 *
 * @phpstan-type TelemetryDestinationWorkspacesIncludeParamsShape = array{
 *   type: 'include', workspaceIDs?: list<string>|null
 * }
 */
final class TelemetryDestinationWorkspacesIncludeParams implements BaseModel
{
    /** @use SdkModel<TelemetryDestinationWorkspacesIncludeParamsShape> */
    use SdkModel;

    /** @var 'include' $type */
    #[Required(type: new ConstantOf('include'))]
    public string $type = 'include';

    /**
     * The IDs of the workspaces on the destination's list (`wrkspc_...`). At most 100 per request.
     *
     * On create, these workspaces become the destination's list. If you leave `workspace_ids` out, the list starts empty. If the API refuses one of the IDs, it doesn't create the destination.
     *
     * On update, `workspace_ids` replaces the whole list. A workspace that stays on the list keeps its entry and its `created_at`. An empty array empties the list. If you leave `workspace_ids` out and the type stays the same, the list doesn't change. If you leave it out and the type changes, the new list starts empty. After a change to `include` without `workspace_ids`, the destination doesn't cover any workspace until one is added. After a change to `exclude` without `workspace_ids`, it covers every workspace.
     *
     * An ID sent more than once is added once. An archived workspace can't be added to a list. An update can keep an archived workspace that is already on the list.
     *
     * @var list<string>|null $workspaceIDs
     */
    #[Optional('workspace_ids', list: 'string')]
    public ?array $workspaceIDs;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $workspaceIDs
     */
    public static function with(?array $workspaceIDs = null): self
    {
        $self = new self;

        null !== $workspaceIDs && $self['workspaceIDs'] = $workspaceIDs;

        return $self;
    }

    /**
     * @param 'include' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The IDs of the workspaces on the destination's list (`wrkspc_...`). At most 100 per request.
     *
     * On create, these workspaces become the destination's list. If you leave `workspace_ids` out, the list starts empty. If the API refuses one of the IDs, it doesn't create the destination.
     *
     * On update, `workspace_ids` replaces the whole list. A workspace that stays on the list keeps its entry and its `created_at`. An empty array empties the list. If you leave `workspace_ids` out and the type stays the same, the list doesn't change. If you leave it out and the type changes, the new list starts empty. After a change to `include` without `workspace_ids`, the destination doesn't cover any workspace until one is added. After a change to `exclude` without `workspace_ids`, it covers every workspace.
     *
     * An ID sent more than once is added once. An archived workspace can't be added to a list. An update can keep an archived workspace that is already on the list.
     *
     * @param list<string> $workspaceIDs
     */
    public function withWorkspaceIDs(array $workspaceIDs): self
    {
        $self = clone $this;
        $self['workspaceIDs'] = $workspaceIDs;

        return $self;
    }
}
