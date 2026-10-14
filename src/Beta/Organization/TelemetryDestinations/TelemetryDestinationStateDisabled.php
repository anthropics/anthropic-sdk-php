<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The API doesn't deliver anything to the telemetry destination.
 *
 * Spans produced while it is disabled aren't delivered later.
 *
 * @phpstan-import-type TelemetryDestinationDisabledReasonShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationDisabledReason
 * @phpstan-import-type TelemetryDestinationDisabledReasonVariants from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationDisabledReason
 *
 * @phpstan-type TelemetryDestinationStateDisabledShape = array{
 *   reason: TelemetryDestinationDisabledReasonShape, type: 'disabled'
 * }
 */
final class TelemetryDestinationStateDisabled implements BaseModel
{
    /** @use SdkModel<TelemetryDestinationStateDisabledShape> */
    use SdkModel;

    /** @var 'disabled' $type */
    #[Required(type: new ConstantOf('disabled'))]
    public string $type = 'disabled';

    /**
     * Whether a caller or the API disabled the destination and, when the API did, why. Read-only.
     *
     * @var TelemetryDestinationDisabledReasonVariants $reason
     */
    #[Required(union: TelemetryDestinationDisabledReason::class)]
    public TelemetryDestinationDisabledReasonCaller|TelemetryDestinationDisabledReasonSustainedFailure|TelemetryDestinationDisabledReasonInvalidAddress|TelemetryDestinationDisabledReasonRedirect $reason;

    /**
     * `new TelemetryDestinationStateDisabled()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TelemetryDestinationStateDisabled::with(reason: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TelemetryDestinationStateDisabled())->withReason(...)
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
     * @param TelemetryDestinationDisabledReasonShape $reason
     */
    public static function with(
        TelemetryDestinationDisabledReasonCaller|array|TelemetryDestinationDisabledReasonSustainedFailure|TelemetryDestinationDisabledReasonInvalidAddress|TelemetryDestinationDisabledReasonRedirect $reason,
    ): self {
        $self = new self;

        $self['reason'] = $reason;

        return $self;
    }

    /**
     * Whether a caller or the API disabled the destination and, when the API did, why. Read-only.
     *
     * @param TelemetryDestinationDisabledReasonShape $reason
     */
    public function withReason(
        TelemetryDestinationDisabledReasonCaller|array|TelemetryDestinationDisabledReasonSustainedFailure|TelemetryDestinationDisabledReasonInvalidAddress|TelemetryDestinationDisabledReasonRedirect $reason,
    ): self {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }

    /**
     * @param 'disabled' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
