<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A caller disabled the destination with an update that set `state` to `disabled`.
 *
 * @phpstan-type TelemetryDestinationDisabledReasonCallerShape = array{
 *   type: 'caller'
 * }
 */
final class TelemetryDestinationDisabledReasonCaller implements BaseModel
{
    /** @use SdkModel<TelemetryDestinationDisabledReasonCallerShape> */
    use SdkModel;

    /** @var 'caller' $type */
    #[Required(type: new ConstantOf('caller'))]
    public string $type = 'caller';

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
     * @param 'caller' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
