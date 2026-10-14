<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations\Workspaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A workspace on a telemetry destination's workspace list.
 *
 * Under `include`, the destination covers the workspace. Under `exclude`, the destination covers every workspace except this one. The entry doesn't have an `id`. Its `telemetry_destination_id` and `workspace_id` together identify it.
 *
 * @phpstan-type BetaTelemetryDestinationWorkspaceShape = array{
 *   createdAt: \DateTimeInterface,
 *   telemetryDestinationID: string,
 *   type: 'telemetry_destination_workspace',
 *   workspaceID: string,
 * }
 */
final class BetaTelemetryDestinationWorkspace implements BaseModel
{
    /** @use SdkModel<BetaTelemetryDestinationWorkspaceShape> */
    use SdkModel;

    /** @var 'telemetry_destination_workspace' $type */
    #[Required(type: new ConstantOf('telemetry_destination_workspace'))]
    public string $type = 'telemetry_destination_workspace';

    /**
     * Time the workspace was added to the list.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * ID of the telemetry destination (`tdst_...`).
     */
    #[Required('telemetry_destination_id')]
    public string $telemetryDestinationID;

    /**
     * ID of the workspace (`wrkspc_...`).
     */
    #[Required('workspace_id')]
    public string $workspaceID;

    /**
     * `new BetaTelemetryDestinationWorkspace()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTelemetryDestinationWorkspace::with(
     *   createdAt: ..., telemetryDestinationID: ..., workspaceID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaTelemetryDestinationWorkspace())
     *   ->withCreatedAt(...)
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
        \DateTimeInterface $createdAt,
        string $telemetryDestinationID,
        string $workspaceID,
    ): self {
        $self = new self;

        $self['createdAt'] = $createdAt;
        $self['telemetryDestinationID'] = $telemetryDestinationID;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * Time the workspace was added to the list.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

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
     * @param 'telemetry_destination_workspace' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * ID of the workspace (`wrkspc_...`).
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
