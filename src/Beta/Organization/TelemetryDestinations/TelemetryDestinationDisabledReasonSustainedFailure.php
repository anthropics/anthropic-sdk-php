<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The API disabled the destination because deliveries to it failed, with no successful delivery in between, for longer than a threshold that Anthropic configures and that is not part of this contract. The reason is `invalid_address` instead when the most recent failed delivery failed with an invalid address.
 *
 * @phpstan-type TelemetryDestinationDisabledReasonSustainedFailureShape = array{
 *   type: 'sustained_failure'
 * }
 */
final class TelemetryDestinationDisabledReasonSustainedFailure implements BaseModel
{
    /** @use SdkModel<TelemetryDestinationDisabledReasonSustainedFailureShape> */
    use SdkModel;

    /** @var 'sustained_failure' $type */
    #[Required(type: new ConstantOf('sustained_failure'))]
    public string $type = 'sustained_failure';

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
     * @param 'sustained_failure' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
