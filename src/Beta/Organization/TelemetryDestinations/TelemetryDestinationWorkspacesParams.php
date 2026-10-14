<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationWorkspacesParams\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Which of the organization's workspaces a telemetry destination covers, as a create or update request sets it.
 *
 * @phpstan-import-type TelemetryDestinationWorkspacesAllParamsShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationWorkspacesAllParams
 * @phpstan-import-type TelemetryDestinationWorkspacesIncludeParamsShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationWorkspacesIncludeParams
 * @phpstan-import-type TelemetryDestinationWorkspacesExcludeParamsShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationWorkspacesExcludeParams
 *
 * @phpstan-type TelemetryDestinationWorkspacesParamsVariants = TelemetryDestinationWorkspacesAllParams|TelemetryDestinationWorkspacesIncludeParams|TelemetryDestinationWorkspacesExcludeParams
 * @phpstan-type TelemetryDestinationWorkspacesParamsShape = TelemetryDestinationWorkspacesParamsVariants|TelemetryDestinationWorkspacesAllParamsShape|TelemetryDestinationWorkspacesIncludeParamsShape|TelemetryDestinationWorkspacesExcludeParamsShape
 */
final class TelemetryDestinationWorkspacesParams implements ConverterSource
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
            'all' => TelemetryDestinationWorkspacesAllParams::class,
            'include' => TelemetryDestinationWorkspacesIncludeParams::class,
            'exclude' => TelemetryDestinationWorkspacesExcludeParams::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param list<string>|null $workspaceIDs
     *
     * @return ($type is Type::ALL|'all' ? TelemetryDestinationWorkspacesAllParams : ($type is Type::INCLUDE|'include' ? TelemetryDestinationWorkspacesIncludeParams : ($type is Type::EXCLUDE|'exclude' ? TelemetryDestinationWorkspacesExcludeParams : TelemetryDestinationWorkspacesAllParams|TelemetryDestinationWorkspacesIncludeParams|TelemetryDestinationWorkspacesExcludeParams)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?array $workspaceIDs = null
    ): TelemetryDestinationWorkspacesAllParams|TelemetryDestinationWorkspacesIncludeParams|TelemetryDestinationWorkspacesExcludeParams {
        return match ($type) {
            Type::ALL, 'all' => TelemetryDestinationWorkspacesAllParams::with(),
            Type::INCLUDE, 'include' => TelemetryDestinationWorkspacesIncludeParams::with(
                workspaceIDs: $workspaceIDs
            ),
            Type::EXCLUDE, 'exclude' => TelemetryDestinationWorkspacesExcludeParams::with(
                workspaceIDs: $workspaceIDs
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
