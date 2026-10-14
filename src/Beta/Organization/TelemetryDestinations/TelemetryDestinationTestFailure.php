<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The test span was not delivered.
 *
 * @phpstan-type TelemetryDestinationTestFailureShape = array{
 *   error: string, type: 'failure'
 * }
 */
final class TelemetryDestinationTestFailure implements BaseModel
{
    /** @use SdkModel<TelemetryDestinationTestFailureShape> */
    use SdkModel;

    /** @var 'failure' $type */
    #[Required(type: new ConstantOf('failure'))]
    public string $type = 'failure';

    /**
     * A message that describes why the test span was not delivered, including the HTTP status code when the destination returned one. Examples: `HTTP error (status 403)`, `timeout`, `TLS failure`. It has the same form as the destination's `delivery_health.last_error` and never contains the destination's response body, any header value, a network address, or TLS details.
     */
    #[Required]
    public string $error;

    /**
     * `new TelemetryDestinationTestFailure()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TelemetryDestinationTestFailure::with(error: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TelemetryDestinationTestFailure())->withError(...)
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
    public static function with(string $error): self
    {
        $self = new self;

        $self['error'] = $error;

        return $self;
    }

    /**
     * A message that describes why the test span was not delivered, including the HTTP status code when the destination returned one. Examples: `HTTP error (status 403)`, `timeout`, `TLS failure`. It has the same form as the destination's `delivery_health.last_error` and never contains the destination's response body, any header value, a network address, or TLS details.
     */
    public function withError(string $error): self
    {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    /**
     * @param 'failure' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
