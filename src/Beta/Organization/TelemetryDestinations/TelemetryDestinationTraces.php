<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A telemetry destination's settings for the traces it receives.
 *
 * @phpstan-type TelemetryDestinationTracesShape = array{
 *   contentMode: TelemetryDestinationContentMode|value-of<TelemetryDestinationContentMode>,
 *   enabled: bool,
 *   endpointURL: string|null,
 *   maxContentBytes: int|null,
 * }
 */
final class TelemetryDestinationTraces implements BaseModel
{
    /** @use SdkModel<TelemetryDestinationTracesShape> */
    use SdkModel;

    /**
     * What the exported spans contain.
     *
     * @var value-of<TelemetryDestinationContentMode> $contentMode
     */
    #[Required('content_mode', enum: TelemetryDestinationContentMode::class)]
    public string $contentMode;

    /**
     * Whether the destination receives traces. A destination whose `enabled` is false keeps its other settings.
     */
    #[Required]
    public bool $enabled;

    /**
     * The full URL that the API posts traces to, exactly as registered, or `null` if the destination doesn't have one.
     *
     * When it is `null`, the API posts traces to `endpoint_url` with `/v1/traces` appended.
     */
    #[Required('endpoint_url')]
    public ?string $endpointURL;

    /**
     * The most bytes of content that one exported span can contain, or `null` if only the API's maximum applies.
     *
     * Content means model prompts and responses, and tool inputs and outputs. The API shortens longer content to this size before it delivers the span. A destination whose `content_mode` is `metadata_only` keeps this value. It applies once `content_mode` is `content`.
     */
    #[Required('max_content_bytes')]
    public ?int $maxContentBytes;

    /**
     * `new TelemetryDestinationTraces()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TelemetryDestinationTraces::with(
     *   contentMode: ..., enabled: ..., endpointURL: ..., maxContentBytes: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TelemetryDestinationTraces())
     *   ->withContentMode(...)
     *   ->withEnabled(...)
     *   ->withEndpointURL(...)
     *   ->withMaxContentBytes(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param TelemetryDestinationContentMode|value-of<TelemetryDestinationContentMode> $contentMode
     */
    public static function with(
        TelemetryDestinationContentMode|string $contentMode,
        bool $enabled,
        ?string $endpointURL,
        ?int $maxContentBytes,
    ): self {
        $self = new self;

        $self['contentMode'] = $contentMode;
        $self['enabled'] = $enabled;
        $self['endpointURL'] = $endpointURL;
        $self['maxContentBytes'] = $maxContentBytes;

        return $self;
    }

    /**
     * What the exported spans contain.
     *
     * @param TelemetryDestinationContentMode|value-of<TelemetryDestinationContentMode> $contentMode
     */
    public function withContentMode(
        TelemetryDestinationContentMode|string $contentMode
    ): self {
        $self = clone $this;
        $self['contentMode'] = $contentMode;

        return $self;
    }

    /**
     * Whether the destination receives traces. A destination whose `enabled` is false keeps its other settings.
     */
    public function withEnabled(bool $enabled): self
    {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }

    /**
     * The full URL that the API posts traces to, exactly as registered, or `null` if the destination doesn't have one.
     *
     * When it is `null`, the API posts traces to `endpoint_url` with `/v1/traces` appended.
     */
    public function withEndpointURL(?string $endpointURL): self
    {
        $self = clone $this;
        $self['endpointURL'] = $endpointURL;

        return $self;
    }

    /**
     * The most bytes of content that one exported span can contain, or `null` if only the API's maximum applies.
     *
     * Content means model prompts and responses, and tool inputs and outputs. The API shortens longer content to this size before it delivers the span. A destination whose `content_mode` is `metadata_only` keeps this value. It applies once `content_mode` is `content`.
     */
    public function withMaxContentBytes(?int $maxContentBytes): self
    {
        $self = clone $this;
        $self['maxContentBytes'] = $maxContentBytes;

        return $self;
    }
}
