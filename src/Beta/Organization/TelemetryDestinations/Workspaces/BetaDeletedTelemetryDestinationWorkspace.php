<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations\Workspaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Confirmation that a workspace was removed from a destination's list.
 *
 * @phpstan-type BetaDeletedTelemetryDestinationWorkspaceShape = array{
 *   telemetryDestinationID: string,
 *   type: 'telemetry_destination_workspace_deleted',
 *   workspaceID: string,
 * }
 */
final class BetaDeletedTelemetryDestinationWorkspace implements BaseModel
{
    /** @use SdkModel<BetaDeletedTelemetryDestinationWorkspaceShape> */
    use SdkModel;

    /** @var 'telemetry_destination_workspace_deleted' $type */
    #[Required(type: new ConstantOf('telemetry_destination_workspace_deleted'))]
    public string $type = 'telemetry_destination_workspace_deleted';

    /**
     * ID of the telemetry destination (`tdst_...`).
     */
    #[Required('telemetry_destination_id')]
    public string $telemetryDestinationID;

    /**
     * ID of the workspace that was removed (`wrkspc_...`).
     */
    #[Required('workspace_id')]
    public string $workspaceID;

    /**
     * `new BetaDeletedTelemetryDestinationWorkspace()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaDeletedTelemetryDestinationWorkspace::with(
     *   telemetryDestinationID: ..., workspaceID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaDeletedTelemetryDestinationWorkspace())
     *   ->withTelemetryDestinationID(...)
     *   ->withWorkspaceID(...)
     * ```
     */
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
        string $telemetryDestinationID,
        string $workspaceID
    ): self {
        $self = new self;

        $self['telemetryDestinationID'] = $telemetryDestinationID;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * ID of the telemetry destination (`tdst_...`).
     */
    public function withTelemetryDestinationID(
        string $telemetryDestinationID
    ): self {
        $self = clone $this;
        $self['telemetryDestinationID'] = $telemetryDestinationID;

        return $self;
    }

    /**
     * @param 'telemetry_destination_workspace_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * ID of the workspace that was removed (`wrkspc_...`).
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
