<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The outcome of a test: `success`, or `failure` with the reason.
 *
 * @phpstan-import-type TelemetryDestinationTestSuccessShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationTestSuccess
 * @phpstan-import-type TelemetryDestinationTestFailureShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationTestFailure
 *
 * @phpstan-type TelemetryDestinationTestResultVariants = TelemetryDestinationTestSuccess|TelemetryDestinationTestFailure
 * @phpstan-type TelemetryDestinationTestResultShape = TelemetryDestinationTestResultVariants|TelemetryDestinationTestSuccessShape|TelemetryDestinationTestFailureShape
 */
final class TelemetryDestinationTestResult implements ConverterSource
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
            'success' => TelemetryDestinationTestSuccess::class,
            'failure' => TelemetryDestinationTestFailure::class,
        ];
    }
}
