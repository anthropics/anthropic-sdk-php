<?php

declare(strict_types=1);

namespace Anthropic\Beta\Webhooks;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebhookEnvironmentDeletedEventDataShape = array{
 *   id: string,
 *   organizationID: string,
 *   type: BetaWebhookEnvironmentDeletedEventType|value-of<BetaWebhookEnvironmentDeletedEventType>,
 *   workspaceID: string,
 * }
 */
final class BetaWebhookEnvironmentDeletedEventData implements BaseModel
{
    /** @use SdkModel<BetaWebhookEnvironmentDeletedEventDataShape> */
    use SdkModel;

    /**
     * ID of the environment that triggered the event.
     */
    #[Required]
    public string $id;

    #[Required('organization_id')]
    public string $organizationID;

    /** @var value-of<BetaWebhookEnvironmentDeletedEventType> $type */
    #[Required(enum: BetaWebhookEnvironmentDeletedEventType::class)]
    public string $type;

    #[Required('workspace_id')]
    public string $workspaceID;

    /**
     * `new BetaWebhookEnvironmentDeletedEventData()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebhookEnvironmentDeletedEventData::with(
     *   id: ..., organizationID: ..., type: ..., workspaceID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebhookEnvironmentDeletedEventData)
     *   ->withID(...)
     *   ->withOrganizationID(...)
     *   ->withType(...)
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
     *
     * @param BetaWebhookEnvironmentDeletedEventType|value-of<BetaWebhookEnvironmentDeletedEventType> $type
     */
    public static function with(
        string $id,
        string $organizationID,
        BetaWebhookEnvironmentDeletedEventType|string $type,
        string $workspaceID,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['organizationID'] = $organizationID;
        $self['type'] = $type;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * ID of the environment that triggered the event.
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
     * @param BetaWebhookEnvironmentDeletedEventType|value-of<BetaWebhookEnvironmentDeletedEventType> $type
     */
    public function withType(
        BetaWebhookEnvironmentDeletedEventType|string $type
    ): self {
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
