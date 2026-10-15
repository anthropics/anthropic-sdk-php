<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Register an OpenTelemetry destination for the organization.
 *
 * The destination starts in state `enabled`. An organization can have at most 10 destinations, including disabled ones.
 *
 * See the [OpenTelemetry export guide](https://platform.claude.com/docs/en/manage-claude/opentelemetry#add-a-destination) to learn more about adding a destination.
 *
 * @see Anthropic\Services\Beta\Organization\TelemetryDestinationsService::create()
 *
 * @phpstan-import-type TelemetryDestinationWorkspacesParamsShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationWorkspacesParams
 * @phpstan-import-type TelemetryDestinationTracesParamsShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationTracesParams
 * @phpstan-import-type TelemetryDestinationWorkspacesParamsVariants from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationWorkspacesParams
 *
 * @phpstan-type TelemetryDestinationCreateParamsShape = array{
 *   endpointURL: string,
 *   workspaces: TelemetryDestinationWorkspacesParamsShape,
 *   displayName?: string|null,
 *   headers?: array<string,string>|null,
 *   traces?: null|TelemetryDestinationTracesParams|TelemetryDestinationTracesParamsShape,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class TelemetryDestinationCreateParams implements BaseModel
{
    /** @use SdkModel<TelemetryDestinationCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The base URL of your collector's OTLP/HTTP endpoint, for example `https://gateway.example.com`.
     *
     * The URL must use `https` and a hostname, not an IP address. The port, if given, must be 443. The URL must not contain a query string, a fragment, or a username and password. At most 2,048 characters.
     *
     * A path prefix, such as `/otlp`, is allowed. Don't include the per-signal path (`/v1/traces`), because the API appends it on delivery. If your collector takes traces on another path, also set `traces.endpoint_url`.
     */
    #[Required('endpoint_url')]
    public string $endpointURL;

    /**
     * Which of the organization's workspaces the destination covers.
     *
     * @var TelemetryDestinationWorkspacesParamsVariants $workspaces
     */
    #[Required(union: TelemetryDestinationWorkspacesParams::class)]
    public TelemetryDestinationWorkspacesAllParams|TelemetryDestinationWorkspacesIncludeParams|TelemetryDestinationWorkspacesExcludeParams $workspaces;

    /**
     * Human-readable name for the destination. Optional. 1 to 255 characters.
     */
    #[Optional('display_name', nullable: true)]
    public ?string $displayName;

    /**
     * Request headers that the API sends with every delivery, typically your collector's authentication header (for example `authorization`).
     *
     * The API stores the values encrypted and never returns them. Reads show only `header_names`.
     *
     * At most 20 headers. Names are at most 128 characters. Two names can't differ only in case. Values are printable ASCII, at most 4,096 characters, and can't begin or end with a space. Names and values together are at most 16,384 bytes.
     *
     * Reserved names are rejected, for example `host`, `cookie`, `user-agent`, and names that start with `content-`, `proxy-`, `x-forwarded-`, or `anthropic-`. For this check, `_` in a name counts as `-`.
     *
     * @var array<string,string>|null $headers
     */
    #[Optional(map: 'string')]
    public ?array $headers;

    /**
     * The settings for the traces that the destination receives. If you leave it out, every setting takes its default.
     */
    #[Optional]
    public ?TelemetryDestinationTracesParams $traces;

    /**
     * This endpoint is in beta: requests must send `telemetry-destinations-2026-08-11` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new TelemetryDestinationCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TelemetryDestinationCreateParams::with(endpointURL: ..., workspaces: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TelemetryDestinationCreateParams())
     *   ->withEndpointURL(...)
     *   ->withWorkspaces(...)
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
     * @param TelemetryDestinationWorkspacesParamsShape $workspaces
     * @param array<string,string>|null $headers
     * @param TelemetryDestinationTracesParams|TelemetryDestinationTracesParamsShape|null $traces
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        string $endpointURL,
        TelemetryDestinationWorkspacesAllParams|array|TelemetryDestinationWorkspacesIncludeParams|TelemetryDestinationWorkspacesExcludeParams $workspaces,
        ?string $displayName = null,
        ?array $headers = null,
        TelemetryDestinationTracesParams|array|null $traces = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['endpointURL'] = $endpointURL;
        $self['workspaces'] = $workspaces;

        null !== $displayName && $self['displayName'] = $displayName;
        null !== $headers && $self['headers'] = $headers;
        null !== $traces && $self['traces'] = $traces;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * The base URL of your collector's OTLP/HTTP endpoint, for example `https://gateway.example.com`.
     *
     * The URL must use `https` and a hostname, not an IP address. The port, if given, must be 443. The URL must not contain a query string, a fragment, or a username and password. At most 2,048 characters.
     *
     * A path prefix, such as `/otlp`, is allowed. Don't include the per-signal path (`/v1/traces`), because the API appends it on delivery. If your collector takes traces on another path, also set `traces.endpoint_url`.
     */
    public function withEndpointURL(string $endpointURL): self
    {
        $self = clone $this;
        $self['endpointURL'] = $endpointURL;

        return $self;
    }

    /**
     * Which of the organization's workspaces the destination covers.
     *
     * @param TelemetryDestinationWorkspacesParamsShape $workspaces
     */
    public function withWorkspaces(
        TelemetryDestinationWorkspacesAllParams|array|TelemetryDestinationWorkspacesIncludeParams|TelemetryDestinationWorkspacesExcludeParams $workspaces,
    ): self {
        $self = clone $this;
        $self['workspaces'] = $workspaces;

        return $self;
    }

    /**
     * Human-readable name for the destination. Optional. 1 to 255 characters.
     */
    public function withDisplayName(?string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * Request headers that the API sends with every delivery, typically your collector's authentication header (for example `authorization`).
     *
     * The API stores the values encrypted and never returns them. Reads show only `header_names`.
     *
     * At most 20 headers. Names are at most 128 characters. Two names can't differ only in case. Values are printable ASCII, at most 4,096 characters, and can't begin or end with a space. Names and values together are at most 16,384 bytes.
     *
     * Reserved names are rejected, for example `host`, `cookie`, `user-agent`, and names that start with `content-`, `proxy-`, `x-forwarded-`, or `anthropic-`. For this check, `_` in a name counts as `-`.
     *
     * @param array<string,string> $headers
     */
    public function withHeaders(array $headers): self
    {
        $self = clone $this;
        $self['headers'] = $headers;

        return $self;
    }

    /**
     * The settings for the traces that the destination receives. If you leave it out, every setting takes its default.
     *
     * @param TelemetryDestinationTracesParams|TelemetryDestinationTracesParamsShape $traces
     */
    public function withTraces(
        TelemetryDestinationTracesParams|array $traces
    ): self {
        $self = clone $this;
        $self['traces'] = $traces;

        return $self;
    }

    /**
     * This endpoint is in beta: requests must send `telemetry-destinations-2026-08-11` in this header.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
