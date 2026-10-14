<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * An OpenTelemetry destination: an OTLP/HTTP endpoint, the request headers sent with every delivery to it, what the exported spans contain, and which workspaces it covers. A destination belongs to an organization. A workspace's spans go to every enabled destination that covers it.
 *
 * @phpstan-import-type TelemetryDestinationDeliveryHealthShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationDeliveryHealth
 * @phpstan-import-type TelemetryDestinationStateShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationState
 * @phpstan-import-type TelemetryDestinationTracesShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationTraces
 * @phpstan-import-type TelemetryDestinationWorkspacesShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationWorkspaces
 * @phpstan-import-type TelemetryDestinationStateVariants from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationState
 * @phpstan-import-type TelemetryDestinationWorkspacesVariants from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationWorkspaces
 *
 * @phpstan-type TelemetryDestinationShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   deliveryHealth: TelemetryDestinationDeliveryHealth|TelemetryDestinationDeliveryHealthShape,
 *   displayName: string|null,
 *   endpointURL: string,
 *   headerNames: list<string>,
 *   state: TelemetryDestinationStateShape,
 *   traces: TelemetryDestinationTraces|TelemetryDestinationTracesShape,
 *   type: 'telemetry_destination',
 *   updatedAt: \DateTimeInterface,
 *   workspaces: TelemetryDestinationWorkspacesShape,
 * }
 */
final class TelemetryDestination implements BaseModel
{
    /** @use SdkModel<TelemetryDestinationShape> */
    use SdkModel;

    /** @var 'telemetry_destination' $type */
    #[Required(type: new ConstantOf('telemetry_destination'))]
    public string $type = 'telemetry_destination';

    /**
     * The unique ID of the destination (`tdst_...`).
     */
    #[Required]
    public string $id;

    /**
     * Time the destination was created.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * The most recent delivery results for this destination.
     */
    #[Required('delivery_health')]
    public TelemetryDestinationDeliveryHealth $deliveryHealth;

    /**
     * Human-readable name for the destination. Null when none was set.
     */
    #[Required('display_name')]
    public ?string $displayName;

    /**
     * The base URL of the destination's OTLP/HTTP endpoint, exactly as registered.
     *
     * The API appends the per-signal path, such as `/v1/traces`, on delivery, unless `traces.endpoint_url` is set.
     */
    #[Required('endpoint_url')]
    public string $endpointURL;

    /**
     * Names of the registered request headers. Header values are write-only and are never returned.
     *
     * @var list<string> $headerNames
     */
    #[Required('header_names', list: 'string')]
    public array $headerNames;

    /**
     * Whether the destination receives deliveries.
     *
     * @var TelemetryDestinationStateVariants $state
     */
    #[Required(union: TelemetryDestinationState::class)]
    public TelemetryDestinationStateEnabled|TelemetryDestinationStateDisabled $state;

    /**
     * The destination's settings for the traces it receives.
     */
    #[Required]
    public TelemetryDestinationTraces $traces;

    /**
     * Time of the last change to the destination's configuration or state. Changes to `delivery_health` don't change it.
     *
     * An update that sets a header value always changes it, even when the value is the same as before. Adding or removing a single workspace on the destination's list doesn't change it. An update that changes the list does.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * Which of the organization's workspaces the destination covers.
     *
     * @var TelemetryDestinationWorkspacesVariants $workspaces
     */
    #[Required(union: TelemetryDestinationWorkspaces::class)]
    public TelemetryDestinationWorkspacesAll|TelemetryDestinationWorkspacesInclude|TelemetryDestinationWorkspacesExclude $workspaces;

    /**
     * `new TelemetryDestination()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TelemetryDestination::with(
     *   id: ...,
     *   createdAt: ...,
     *   deliveryHealth: ...,
     *   displayName: ...,
     *   endpointURL: ...,
     *   headerNames: ...,
     *   state: ...,
     *   traces: ...,
     *   updatedAt: ...,
     *   workspaces: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TelemetryDestination())
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withDeliveryHealth(...)
     *   ->withDisplayName(...)
     *   ->withEndpointURL(...)
     *   ->withHeaderNames(...)
     *   ->withState(...)
     *   ->withTraces(...)
     *   ->withUpdatedAt(...)
     *   ->withWorkspaces(...)
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
     * @param TelemetryDestinationDeliveryHealth|TelemetryDestinationDeliveryHealthShape $deliveryHealth
     * @param list<string> $headerNames
     * @param TelemetryDestinationStateShape $state
     * @param TelemetryDestinationTraces|TelemetryDestinationTracesShape $traces
     * @param TelemetryDestinationWorkspacesShape $workspaces
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        TelemetryDestinationDeliveryHealth|array $deliveryHealth,
        ?string $displayName,
        string $endpointURL,
        array $headerNames,
        TelemetryDestinationStateEnabled|array|TelemetryDestinationStateDisabled $state,
        TelemetryDestinationTraces|array $traces,
        \DateTimeInterface $updatedAt,
        TelemetryDestinationWorkspacesAll|array|TelemetryDestinationWorkspacesInclude|TelemetryDestinationWorkspacesExclude $workspaces,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['deliveryHealth'] = $deliveryHealth;
        $self['displayName'] = $displayName;
        $self['endpointURL'] = $endpointURL;
        $self['headerNames'] = $headerNames;
        $self['state'] = $state;
        $self['traces'] = $traces;
        $self['updatedAt'] = $updatedAt;
        $self['workspaces'] = $workspaces;

        return $self;
    }

    /**
     * The unique ID of the destination (`tdst_...`).
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Time the destination was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * The most recent delivery results for this destination.
     *
     * @param TelemetryDestinationDeliveryHealth|TelemetryDestinationDeliveryHealthShape $deliveryHealth
     */
    public function withDeliveryHealth(
        TelemetryDestinationDeliveryHealth|array $deliveryHealth
    ): self {
        $self = clone $this;
        $self['deliveryHealth'] = $deliveryHealth;

        return $self;
    }

    /**
     * Human-readable name for the destination. Null when none was set.
     */
    public function withDisplayName(?string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * The base URL of the destination's OTLP/HTTP endpoint, exactly as registered.
     *
     * The API appends the per-signal path, such as `/v1/traces`, on delivery, unless `traces.endpoint_url` is set.
     */
    public function withEndpointURL(string $endpointURL): self
    {
        $self = clone $this;
        $self['endpointURL'] = $endpointURL;

        return $self;
    }

    /**
     * Names of the registered request headers. Header values are write-only and are never returned.
     *
     * @param list<string> $headerNames
     */
    public function withHeaderNames(array $headerNames): self
    {
        $self = clone $this;
        $self['headerNames'] = $headerNames;

        return $self;
    }

    /**
     * Whether the destination receives deliveries.
     *
     * @param TelemetryDestinationStateShape $state
     */
    public function withState(
        TelemetryDestinationStateEnabled|array|TelemetryDestinationStateDisabled $state,
    ): self {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }

    /**
     * The destination's settings for the traces it receives.
     *
     * @param TelemetryDestinationTraces|TelemetryDestinationTracesShape $traces
     */
    public function withTraces(TelemetryDestinationTraces|array $traces): self
    {
        $self = clone $this;
        $self['traces'] = $traces;

        return $self;
    }

    /**
     * @param 'telemetry_destination' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Time of the last change to the destination's configuration or state. Changes to `delivery_health` don't change it.
     *
     * An update that sets a header value always changes it, even when the value is the same as before. Adding or removing a single workspace on the destination's list doesn't change it. An update that changes the list does.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Which of the organization's workspaces the destination covers.
     *
     * @param TelemetryDestinationWorkspacesShape $workspaces
     */
    public function withWorkspaces(
        TelemetryDestinationWorkspacesAll|array|TelemetryDestinationWorkspacesInclude|TelemetryDestinationWorkspacesExclude $workspaces,
    ): self {
        $self = clone $this;
        $self['workspaces'] = $workspaces;

        return $self;
    }
}
