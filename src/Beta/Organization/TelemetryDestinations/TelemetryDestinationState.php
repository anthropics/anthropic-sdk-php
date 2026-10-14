<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Whether a telemetry destination receives deliveries.
 *
 * A caller can set either state. The API also disables an enabled destination on its own in some cases. The `reason` of the disabled state says whether a caller or the API disabled the destination and, when the API did, why.
 *
 * See the [OpenTelemetry export guide](https://platform.claude.com/docs/en/manage-claude/opentelemetry#delivery-and-health) to learn when the API disables a destination.
 *
 * @phpstan-import-type TelemetryDestinationStateEnabledShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationStateEnabled
 * @phpstan-import-type TelemetryDestinationStateDisabledShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationStateDisabled
 *
 * @phpstan-type TelemetryDestinationStateVariants = TelemetryDestinationStateEnabled|TelemetryDestinationStateDisabled
 * @phpstan-type TelemetryDestinationStateShape = TelemetryDestinationStateVariants|TelemetryDestinationStateEnabledShape|TelemetryDestinationStateDisabledShape
 */
final class TelemetryDestinationState implements ConverterSource
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
            'enabled' => TelemetryDestinationStateEnabled::class,
            'disabled' => TelemetryDestinationStateDisabled::class,
        ];
    }
}
