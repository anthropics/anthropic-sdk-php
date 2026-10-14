<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The settings for the traces that a telemetry destination receives, as a create or update request sets them. An omitted field takes its default on create and keeps its stored value on update.
 *
 * @phpstan-type TelemetryDestinationTracesParamsShape = array{
 *   contentMode?: null|TelemetryDestinationContentMode|value-of<TelemetryDestinationContentMode>,
 *   enabled?: bool|null,
 *   endpointURL?: string|null,
 *   maxContentBytes?: int|null,
 * }
 */
final class TelemetryDestinationTracesParams implements BaseModel
{
    /** @use SdkModel<TelemetryDestinationTracesParamsShape> */
    use SdkModel;

    /**
     * What the exported spans contain. Defaults to `metadata_only` on create.
     *
     * On update, `null` sets `metadata_only`.
     *
     * @var value-of<TelemetryDestinationContentMode>|null $contentMode
     */
    #[Optional(
        'content_mode',
        enum: TelemetryDestinationContentMode::class,
        nullable: true
    )]
    public ?string $contentMode;

    /**
     * Whether the destination receives traces. Defaults to true on create. It cannot be null.
     */
    #[Optional]
    public ?bool $enabled;

    /**
     * The full URL of your collector's traces endpoint, for a collector that takes traces on a path other than `/v1/traces`. The API posts traces to it exactly as given and appends nothing.
     *
     * The same rules as for `endpoint_url` apply, except that any path is allowed. It must have the same scheme, host, and port as `endpoint_url`. At most 2,048 characters.
     *
     * On create, `null` is the same as leaving it out. On update, `null` removes it. The API then posts traces to `endpoint_url` with `/v1/traces` appended. A change of this URL alone keeps the registered headers.
     */
    #[Optional('endpoint_url', nullable: true)]
    public ?string $endpointURL;

    /**
     * The most bytes of content that one exported span can contain, from 1 up to the API's maximum. `null` sets no bound, so only the API's maximum applies.
     *
     * On create, leaving it out is the same as `null`. The error for a value above the maximum states the maximum.
     */
    #[Optional('max_content_bytes', nullable: true)]
    public ?int $maxContentBytes;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param TelemetryDestinationContentMode|value-of<TelemetryDestinationContentMode>|null $contentMode
     */
    public static function with(
        TelemetryDestinationContentMode|string|null $contentMode = null,
        ?bool $enabled = null,
        ?string $endpointURL = null,
        ?int $maxContentBytes = null,
    ): self {
        $self = new self;

        null !== $contentMode && $self['contentMode'] = $contentMode;
        null !== $enabled && $self['enabled'] = $enabled;
        null !== $endpointURL && $self['endpointURL'] = $endpointURL;
        null !== $maxContentBytes && $self['maxContentBytes'] = $maxContentBytes;

        return $self;
    }

    /**
     * What the exported spans contain. Defaults to `metadata_only` on create.
     *
     * On update, `null` sets `metadata_only`.
     *
     * @param TelemetryDestinationContentMode|value-of<TelemetryDestinationContentMode>|null $contentMode
     */
    public function withContentMode(
        TelemetryDestinationContentMode|string|null $contentMode
    ): self {
        $self = clone $this;
        $self['contentMode'] = $contentMode;

        return $self;
    }

    /**
     * Whether the destination receives traces. Defaults to true on create. It cannot be null.
     */
    public function withEnabled(bool $enabled): self
    {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }

    /**
     * The full URL of your collector's traces endpoint, for a collector that takes traces on a path other than `/v1/traces`. The API posts traces to it exactly as given and appends nothing.
     *
     * The same rules as for `endpoint_url` apply, except that any path is allowed. It must have the same scheme, host, and port as `endpoint_url`. At most 2,048 characters.
     *
     * On create, `null` is the same as leaving it out. On update, `null` removes it. The API then posts traces to `endpoint_url` with `/v1/traces` appended. A change of this URL alone keeps the registered headers.
     */
    public function withEndpointURL(?string $endpointURL): self
    {
        $self = clone $this;
        $self['endpointURL'] = $endpointURL;

        return $self;
    }

    /**
     * The most bytes of content that one exported span can contain, from 1 up to the API's maximum. `null` sets no bound, so only the API's maximum applies.
     *
     * On create, leaving it out is the same as `null`. The error for a value above the maximum states the maximum.
     */
    public function withMaxContentBytes(?int $maxContentBytes): self
    {
        $self = clone $this;
        $self['maxContentBytes'] = $maxContentBytes;

        return $self;
    }
}
