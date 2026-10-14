<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationStateParams\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The state to set on a telemetry destination, by `type` alone.
 *
 * A caller can't set the `reason` of a disabled state. Only the API sets it.
 *
 * @phpstan-import-type TelemetryDestinationStateEnabledParamsShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationStateEnabledParams
 * @phpstan-import-type TelemetryDestinationStateDisabledParamsShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationStateDisabledParams
 *
 * @phpstan-type TelemetryDestinationStateParamsVariants = TelemetryDestinationStateEnabledParams|TelemetryDestinationStateDisabledParams
 * @phpstan-type TelemetryDestinationStateParamsShape = TelemetryDestinationStateParamsVariants|TelemetryDestinationStateEnabledParamsShape|TelemetryDestinationStateDisabledParamsShape
 */
final class TelemetryDestinationStateParams implements ConverterSource
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
            'enabled' => TelemetryDestinationStateEnabledParams::class,
            'disabled' => TelemetryDestinationStateDisabledParams::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::ENABLED|'enabled' ? TelemetryDestinationStateEnabledParams : ($type is Type::DISABLED|'disabled' ? TelemetryDestinationStateDisabledParams : TelemetryDestinationStateEnabledParams|TelemetryDestinationStateDisabledParams))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type
    ): TelemetryDestinationStateEnabledParams|TelemetryDestinationStateDisabledParams {
        return match ($type) {
            Type::ENABLED, 'enabled' => TelemetryDestinationStateEnabledParams::with(
            ),
            Type::DISABLED, 'disabled' => TelemetryDestinationStateDisabledParams::with(
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
