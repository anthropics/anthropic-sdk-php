<?php

declare(strict_types=1);

namespace Anthropic\Beta\Webhooks;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebhookDeploymentUnpausedEventDataShape = array{
 *   id: string,
 *   organizationID: string,
 *   type: 'deployment.unpaused',
 *   workspaceID: string,
 * }
 */
final class BetaWebhookDeploymentUnpausedEventData implements BaseModel
{
    /** @use SdkModel<BetaWebhookDeploymentUnpausedEventDataShape> */
    use SdkModel;

    /** @var 'deployment.unpaused' $type */
    #[Required]
    public string $type = 'deployment.unpaused';

    /**
     * ID of the deployment that triggered the event.
     */
    #[Required]
    public string $id;

    #[Required('organization_id')]
    public string $organizationID;

    #[Required('workspace_id')]
    public string $workspaceID;

    /**
     * `new BetaWebhookDeploymentUnpausedEventData()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebhookDeploymentUnpausedEventData::with(
     *   id: ..., organizationID: ..., workspaceID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebhookDeploymentUnpausedEventData)
     *   ->withID(...)
     *   ->withOrganizationID(...)
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
        string $id,
        string $organizationID,
        string $workspaceID
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['organizationID'] = $organizationID;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * ID of the deployment that triggered the event.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withOrganizationID(string $organizationID): self
    {
        $self = clone $this;
        $self['organizationID'] = $organizationID;

        return $self;
    }

    /**
     * @param 'deployment.unpaused' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
