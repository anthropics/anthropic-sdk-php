<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The destination answered the test span with a 2xx status.
 *
 * @phpstan-type TelemetryDestinationTestSuccessShape = array{type: 'success'}
 */
final class TelemetryDestinationTestSuccess implements BaseModel
{
    /** @use SdkModel<TelemetryDestinationTestSuccessShape> */
    use SdkModel;

    /** @var 'success' $type */
    #[Required(type: new ConstantOf('success'))]
    public string $type = 'success';

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
     * @param 'success' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
