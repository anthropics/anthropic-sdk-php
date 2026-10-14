<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

/**
 * What the spans that the API exports to a telemetry destination contain.
 *
 * See the [OpenTelemetry export guide](https://platform.claude.com/docs/en/manage-claude/opentelemetry#choose-a-content-mode) to learn what the spans contain in each content mode.
 */
enum TelemetryDestinationContentMode: string
{
    /**
     * The spans contain identifiers, timing, status, token counts, and similar metadata. They don't contain prompt text, completion text, or tool inputs and outputs.
     */
    case METADATA_ONLY = 'metadata_only';

    /**
     * The spans contain the same metadata as `metadata_only`, plus message and tool content.
     *
     * An organization with a data-handling restriction, such as under HIPAA, can't choose this mode. The API exports only metadata for such an organization, even to a destination that already has `content`.
     */
    case CONTENT = 'content';
}
