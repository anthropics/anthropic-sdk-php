<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Webhooks;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Webhooks\WebhookUpdateParams\EnabledEvent;
use Anthropic\Beta\Organization\Webhooks\WebhookUpdateParams\State;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Update an organization webhook endpoint. Only the fields you send are changed.
 *
 * Every request must include the beta header `anthropic-beta: webhooks-2026-10-07`. A request without it returns `404`, exactly as if this API did not exist. Anthropic turns organization webhook endpoints on for each organization; until yours is on, requests also return `404`. Organization webhook endpoints are in beta and are not available to organizations with HIPAA readiness enabled.
 *
 * @see Anthropic\Services\Beta\Organization\WebhooksService::update()
 *
 * @phpstan-type WebhookUpdateParamsShape = array{
 *   description?: string|null,
 *   enabledEvents?: list<EnabledEvent|value-of<EnabledEvent>>|null,
 *   name?: string|null,
 *   state?: null|State|value-of<State>,
 *   url?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class WebhookUpdateParams implements BaseModel
{
    /** @use SdkModel<WebhookUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Notes about the endpoint.
     */
    #[Optional]
    public ?string $description;

    /**
     * The event types to deliver to the endpoint. Replaces the whole set; an empty list leaves it unchanged.
     *
     * @var list<value-of<EnabledEvent>>|null $enabledEvents
     */
    #[Optional('enabled_events', list: EnabledEvent::class)]
    public ?array $enabledEvents;

    /**
     * A short label for the endpoint.
     */
    #[Optional]
    public ?string $name;

    /**
     * `disabled` stops deliveries. `enabled` resumes them and clears `disabled_reason`. Events that happen while the endpoint is disabled are never delivered.
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * The HTTPS URL that deliveries are sent to.
     */
    #[Optional]
    public ?string $url;

    /**
     * This endpoint is in beta: requests must send `webhooks-2026-10-07` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<EnabledEvent|value-of<EnabledEvent>>|null $enabledEvents
     * @param State|value-of<State>|null $state
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?string $description = null,
        ?array $enabledEvents = null,
        ?string $name = null,
        State|string|null $state = null,
        ?string $url = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $description && $self['description'] = $description;
        null !== $enabledEvents && $self['enabledEvents'] = $enabledEvents;
        null !== $name && $self['name'] = $name;
        null !== $state && $self['state'] = $state;
        null !== $url && $self['url'] = $url;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Notes about the endpoint.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * The event types to deliver to the endpoint. Replaces the whole set; an empty list leaves it unchanged.
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
     * A short label for the endpoint.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * `disabled` stops deliveries. `enabled` resumes them and clears `disabled_reason`. Events that happen while the endpoint is disabled are never delivered.
     *
     * @param State|value-of<State> $state
     */
    public function withState(State|string $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

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

    /**
     * This endpoint is in beta: requests must send `webhooks-2026-10-07` in this header.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
