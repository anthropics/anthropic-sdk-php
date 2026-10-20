<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Webhooks;

use Anthropic\Beta\Organization\Webhooks\OrganizationWebhookEndpoint\EnabledEvent;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A webhook endpoint that belongs to the organization rather than to one of
 * its workspaces.
 *
 * @phpstan-type OrganizationWebhookEndpointShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   description: string,
 *   disabledReason: string,
 *   enabledEvents: list<EnabledEvent|value-of<EnabledEvent>>,
 *   name: string,
 *   state: OrganizationWebhookEndpointState|value-of<OrganizationWebhookEndpointState>,
 *   updatedAt: \DateTimeInterface,
 *   url: string,
 * }
 */
final class OrganizationWebhookEndpoint implements BaseModel
{
    /** @use SdkModel<OrganizationWebhookEndpointShape> */
    use SdkModel;

    /**
     * ID of the webhook endpoint.
     */
    #[Required]
    public string $id;

    /**
     * When the endpoint was created, in RFC 3339 format.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Notes about the endpoint. An empty string when none were given.
     */
    #[Required]
    public string $description;

    /**
     * Why Anthropic disabled the endpoint automatically. An empty string when the endpoint is enabled, or when you disabled it.
     */
    #[Required('disabled_reason')]
    public string $disabledReason;

    /**
     * The event types delivered to the endpoint.
     *
     * @var list<value-of<EnabledEvent>> $enabledEvents
     */
    #[Required('enabled_events', list: EnabledEvent::class)]
    public array $enabledEvents;

    /**
     * A short label for the endpoint. An empty string when none was given.
     */
    #[Required]
    public string $name;

    /**
     * Whether deliveries are sent to the endpoint.
     *
     * @var value-of<OrganizationWebhookEndpointState> $state
     */
    #[Required(enum: OrganizationWebhookEndpointState::class)]
    public string $state;

    /**
     * When the endpoint was last changed, in RFC 3339 format.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * The HTTPS URL that deliveries are sent to.
     */
    #[Required]
    public string $url;

    /**
     * `new OrganizationWebhookEndpoint()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * OrganizationWebhookEndpoint::with(
     *   id: ...,
     *   createdAt: ...,
     *   description: ...,
     *   disabledReason: ...,
     *   enabledEvents: ...,
     *   name: ...,
     *   state: ...,
     *   updatedAt: ...,
     *   url: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new OrganizationWebhookEndpoint())
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withDescription(...)
     *   ->withDisabledReason(...)
     *   ->withEnabledEvents(...)
     *   ->withName(...)
     *   ->withState(...)
     *   ->withUpdatedAt(...)
     *   ->withURL(...)
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
     * @param list<EnabledEvent|value-of<EnabledEvent>> $enabledEvents
     * @param OrganizationWebhookEndpointState|value-of<OrganizationWebhookEndpointState> $state
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        string $description,
        string $disabledReason,
        array $enabledEvents,
        string $name,
        OrganizationWebhookEndpointState|string $state,
        \DateTimeInterface $updatedAt,
        string $url,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['description'] = $description;
        $self['disabledReason'] = $disabledReason;
        $self['enabledEvents'] = $enabledEvents;
        $self['name'] = $name;
        $self['state'] = $state;
        $self['updatedAt'] = $updatedAt;
        $self['url'] = $url;

        return $self;
    }

    /**
     * ID of the webhook endpoint.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * When the endpoint was created, in RFC 3339 format.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Notes about the endpoint. An empty string when none were given.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Why Anthropic disabled the endpoint automatically. An empty string when the endpoint is enabled, or when you disabled it.
     */
    public function withDisabledReason(string $disabledReason): self
    {
        $self = clone $this;
        $self['disabledReason'] = $disabledReason;

        return $self;
    }

    /**
     * The event types delivered to the endpoint.
     *
     * @param list<EnabledEvent|value-of<EnabledEvent>> $enabledEvents
     */
    public function withEnabledEvents(array $enabledEvents): self
    {
        $self = clone $this;
        $self['enabledEvents'] = $enabledEvents;

        return $self;
    }

    /**
     * A short label for the endpoint. An empty string when none was given.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Whether deliveries are sent to the endpoint.
     *
     * @param OrganizationWebhookEndpointState|value-of<OrganizationWebhookEndpointState> $state
     */
    public function withState(
        OrganizationWebhookEndpointState|string $state
    ): self {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }

    /**
     * When the endpoint was last changed, in RFC 3339 format.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * The HTTPS URL that deliveries are sent to.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
