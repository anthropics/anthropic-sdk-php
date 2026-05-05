<?php

declare(strict_types=1);

namespace Anthropic\Beta\Webhooks;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebhookSessionThreadTerminatedEventDataShape = array{
 *   id: string,
 *   organizationID: string,
 *   type: 'session.thread_terminated',
 *   workspaceID: string,
 * }
 */
final class BetaWebhookSessionThreadTerminatedEventData implements BaseModel
{
    /** @use SdkModel<BetaWebhookSessionThreadTerminatedEventDataShape> */
    use SdkModel;

    /** @var 'session.thread_terminated' $type */
    #[Required]
    public string $type = 'session.thread_terminated';

    /**
     * ID of the resource that triggered the event.
     */
    #[Required]
    public string $id;

    #[Required('organization_id')]
    public string $organizationID;

    #[Required('workspace_id')]
    public string $workspaceID;

    /**
     * `new BetaWebhookSessionThreadTerminatedEventData()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebhookSessionThreadTerminatedEventData::with(
     *   id: ..., organizationID: ..., workspaceID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebhookSessionThreadTerminatedEventData)
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
     * ID of the resource that triggered the event.
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
     * @param 'session.thread_terminated' $type
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
