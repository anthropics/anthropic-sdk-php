<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Which of the organization's workspaces a telemetry destination covers.
 *
 * Several destinations can cover the same workspace. Each of them receives the workspace's spans while it is enabled.
 *
 * The workspace list of an `include` or `exclude` destination isn't part of the destination object. List the destination's workspaces to read it. Add or remove one workspace at a time, or replace the whole list with an update. A list holds at most 1,000 workspaces.
 *
 * @phpstan-import-type TelemetryDestinationWorkspacesAllShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationWorkspacesAll
 * @phpstan-import-type TelemetryDestinationWorkspacesIncludeShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationWorkspacesInclude
 * @phpstan-import-type TelemetryDestinationWorkspacesExcludeShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationWorkspacesExclude
 *
 * @phpstan-type TelemetryDestinationWorkspacesVariants = TelemetryDestinationWorkspacesAll|TelemetryDestinationWorkspacesInclude|TelemetryDestinationWorkspacesExclude
 * @phpstan-type TelemetryDestinationWorkspacesShape = TelemetryDestinationWorkspacesVariants|TelemetryDestinationWorkspacesAllShape|TelemetryDestinationWorkspacesIncludeShape|TelemetryDestinationWorkspacesExcludeShape
 */
final class TelemetryDestinationWorkspaces implements ConverterSource
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
            'all' => TelemetryDestinationWorkspacesAll::class,
            'include' => TelemetryDestinationWorkspacesInclude::class,
            'exclude' => TelemetryDestinationWorkspacesExclude::class,
        ];
    }
}
