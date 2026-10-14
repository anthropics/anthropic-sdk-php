<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Why the destination is disabled: `caller` when a caller disabled it, or the reason the API disabled it automatically (`sustained_failure`, `invalid_address`, or `redirect`). Every automatic disable is reversible with an update that sets `state` to `enabled`. An update that sets `disabled` on a destination that is already disabled keeps its reason.
 *
 * @phpstan-import-type TelemetryDestinationDisabledReasonCallerShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationDisabledReasonCaller
 * @phpstan-import-type TelemetryDestinationDisabledReasonSustainedFailureShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationDisabledReasonSustainedFailure
 * @phpstan-import-type TelemetryDestinationDisabledReasonInvalidAddressShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationDisabledReasonInvalidAddress
 * @phpstan-import-type TelemetryDestinationDisabledReasonRedirectShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationDisabledReasonRedirect
 *
 * @phpstan-type TelemetryDestinationDisabledReasonVariants = TelemetryDestinationDisabledReasonCaller|TelemetryDestinationDisabledReasonSustainedFailure|TelemetryDestinationDisabledReasonInvalidAddress|TelemetryDestinationDisabledReasonRedirect
 * @phpstan-type TelemetryDestinationDisabledReasonShape = TelemetryDestinationDisabledReasonVariants|TelemetryDestinationDisabledReasonCallerShape|TelemetryDestinationDisabledReasonSustainedFailureShape|TelemetryDestinationDisabledReasonInvalidAddressShape|TelemetryDestinationDisabledReasonRedirectShape
 */
final class TelemetryDestinationDisabledReason implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'caller' => TelemetryDestinationDisabledReasonCaller::class,
            'sustained_failure' => TelemetryDestinationDisabledReasonSustainedFailure::class,
            'invalid_address' => TelemetryDestinationDisabledReasonInvalidAddress::class,
            'redirect' => TelemetryDestinationDisabledReasonRedirect::class,
        ];
    }
}
