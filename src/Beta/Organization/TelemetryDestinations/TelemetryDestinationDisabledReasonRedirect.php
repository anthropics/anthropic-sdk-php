<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The API disabled the destination because the endpoint answered a delivery with a 3xx status. Redirects are never followed, and one such answer disables the destination at once.
 *
 * @phpstan-type TelemetryDestinationDisabledReasonRedirectShape = array{
 *   type: 'redirect'
 * }
 */
final class TelemetryDestinationDisabledReasonRedirect implements BaseModel
{
    /** @use SdkModel<TelemetryDestinationDisabledReasonRedirectShape> */
    use SdkModel;

    /** @var 'redirect' $type */
    #[Required(type: new ConstantOf('redirect'))]
    public string $type = 'redirect';

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
     * @param 'redirect' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
