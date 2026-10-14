<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Stop deliveries to the telemetry destination.
 *
 * Spans produced while it is disabled aren't delivered later. A destination that is already disabled keeps its `reason`.
 *
 * @phpstan-type TelemetryDestinationStateDisabledParamsShape = array{
 *   type: 'disabled'
 * }
 */
final class TelemetryDestinationStateDisabledParams implements BaseModel
{
    /** @use SdkModel<TelemetryDestinationStateDisabledParamsShape> */
    use SdkModel;

    /** @var 'disabled' $type */
    #[Required(type: new ConstantOf('disabled'))]
    public string $type = 'disabled';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
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
