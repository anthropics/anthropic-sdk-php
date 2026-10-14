<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The most recent delivery results that the API records for a telemetry destination.
 *
 * Changes to the destination's configuration or state don't reset these fields. Changes to these fields don't change `updated_at`. The values can lag behind the latest deliveries.
 *
 * See the [OpenTelemetry export guide](https://platform.claude.com/docs/en/manage-claude/opentelemetry#delivery-and-health) to learn how the API delivers spans and when it disables a destination.
 *
 * @phpstan-type TelemetryDestinationDeliveryHealthShape = array{
 *   lastError: string|null,
 *   lastErrorAt: \DateTimeInterface|null,
 *   lastSuccessAt: \DateTimeInterface|null,
 * }
 */
final class TelemetryDestinationDeliveryHealth implements BaseModel
{
    /** @use SdkModel<TelemetryDestinationDeliveryHealthShape> */
    use SdkModel;

    /**
     * A message that describes the most recent failed delivery to the destination, or `null` if no delivery has failed yet.
     *
     * Examples are `temporary DNS failure`, `TLS failure`, `timeout`, `connection failure`, `invalid address`, `HTTP error (status 503)`, and `redirect (status 301)`. The message is `invalid address` both for a hostname that doesn't exist and for an address that isn't publicly routable. It never contains the endpoint's response body, a header value, a network address, or TLS details.
     *
     * `last_error` and `last_error_at` always change together. A later successful delivery doesn't clear them. If `last_success_at` is later than `last_error_at`, a delivery has succeeded since this failure.
     *
     * See the [OpenTelemetry export guide](https://platform.claude.com/docs/en/manage-claude/opentelemetry#delivery-errors) to learn the likely cause of each error.
     */
    #[Required('last_error')]
    public ?string $lastError;

    /**
     * Time of the failure that `last_error` describes. Changes together with `last_error`. Null until a delivery first fails.
     */
    #[Required('last_error_at')]
    public ?\DateTimeInterface $lastErrorAt;

    /**
     * Time of the most recent successful delivery to the destination, or `null` if no delivery has succeeded yet.
     */
    #[Required('last_success_at')]
    public ?\DateTimeInterface $lastSuccessAt;

    /**
     * `new TelemetryDestinationDeliveryHealth()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TelemetryDestinationDeliveryHealth::with(
     *   lastError: ..., lastErrorAt: ..., lastSuccessAt: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TelemetryDestinationDeliveryHealth())
     *   ->withLastError(...)
     *   ->withLastErrorAt(...)
     *   ->withLastSuccessAt(...)
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
        ?string $lastError,
        ?\DateTimeInterface $lastErrorAt,
        ?\DateTimeInterface $lastSuccessAt,
    ): self {
        $self = new self;

        $self['lastError'] = $lastError;
        $self['lastErrorAt'] = $lastErrorAt;
        $self['lastSuccessAt'] = $lastSuccessAt;

        return $self;
    }

    /**
     * A message that describes the most recent failed delivery to the destination, or `null` if no delivery has failed yet.
     *
     * Examples are `temporary DNS failure`, `TLS failure`, `timeout`, `connection failure`, `invalid address`, `HTTP error (status 503)`, and `redirect (status 301)`. The message is `invalid address` both for a hostname that doesn't exist and for an address that isn't publicly routable. It never contains the endpoint's response body, a header value, a network address, or TLS details.
     *
     * `last_error` and `last_error_at` always change together. A later successful delivery doesn't clear them. If `last_success_at` is later than `last_error_at`, a delivery has succeeded since this failure.
     *
     * See the [OpenTelemetry export guide](https://platform.claude.com/docs/en/manage-claude/opentelemetry#delivery-errors) to learn the likely cause of each error.
     */
    public function withLastError(?string $lastError): self
    {
        $self = clone $this;
        $self['lastError'] = $lastError;

        return $self;
    }

    /**
     * Time of the failure that `last_error` describes. Changes together with `last_error`. Null until a delivery first fails.
     */
    public function withLastErrorAt(?\DateTimeInterface $lastErrorAt): self
    {
        $self = clone $this;
        $self['lastErrorAt'] = $lastErrorAt;

        return $self;
    }

    /**
     * Time of the most recent successful delivery to the destination, or `null` if no delivery has succeeded yet.
     */
    public function withLastSuccessAt(?\DateTimeInterface $lastSuccessAt): self
    {
        $self = clone $this;
        $self['lastSuccessAt'] = $lastSuccessAt;

        return $self;
    }
}
