<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\MapOf;

/**
 * Change a telemetry destination's settings, its state, or which workspaces it covers.
 *
 * Send at least one field. Omitted fields keep their stored values, except the registered headers, which a change of the endpoint's hostname or port removes. Only `display_name`, `traces`, `traces.endpoint_url`, `traces.content_mode`, `traces.max_content_bytes`, and individual `headers` values accept `null`.
 *
 * If another request changes the destination while the update runs, the API returns a 409 `conflict_error`. Read the destination again, then retry the update.
 *
 * See the [OpenTelemetry export guide](https://platform.claude.com/docs/en/manage-claude/opentelemetry#delivery-and-health) to learn more about changing a destination.
 *
 * @see Anthropic\Services\Beta\Organization\TelemetryDestinationsService::update()
 *
 * @phpstan-import-type TelemetryDestinationStateParamsShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationStateParams
 * @phpstan-import-type TelemetryDestinationTracesParamsShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationTracesParams
 * @phpstan-import-type TelemetryDestinationWorkspacesParamsShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationWorkspacesParams
 * @phpstan-import-type TelemetryDestinationStateParamsVariants from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationStateParams
 * @phpstan-import-type TelemetryDestinationWorkspacesParamsVariants from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationWorkspacesParams
 *
 * @phpstan-type TelemetryDestinationUpdateParamsShape = array{
 *   displayName?: string|null,
 *   endpointURL?: string|null,
 *   headers?: array<string,string|null>|null,
 *   state?: TelemetryDestinationStateParamsShape|null,
 *   traces?: null|TelemetryDestinationTracesParams|TelemetryDestinationTracesParamsShape,
 *   workspaces?: TelemetryDestinationWorkspacesParamsShape|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class TelemetryDestinationUpdateParams implements BaseModel
{
    /** @use SdkModel<TelemetryDestinationUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * New human-readable name, 1 to 255 characters. Null clears it.
     */
    #[Optional('display_name', nullable: true)]
    public ?string $displayName;

    /**
     * The new base URL of the destination's OTLP/HTTP endpoint. The same rules as on create apply.
     *
     * A change of hostname or port first removes every registered header, so send the headers for the new endpoint in the same request. When the destination has a `traces.endpoint_url`, such a change must also set `traces.endpoint_url` to a URL with the new hostname and port, or to `null`. A change of the path alone keeps the headers.
     */
    #[Optional('endpoint_url')]
    public ?string $endpointURL;

    /**
     * Headers to set or remove. The API merges them into the destination's headers by name.
     *
     * Names compare case-insensitively. A string value sets or replaces that header. A `null` value removes it. Headers that you omit don't change. The field itself can't be `null`.
     *
     * A request that sets a header value must also include `endpoint_url`. The current URL is accepted.
     *
     * The resulting set must stay within the same limits as on create. When the request sets a value, each stored value that it doesn't set counts as 4,096 bytes toward the 16,384-byte limit, because you can't read its real length. So to change one header of a destination that has four or more other headers, send the values of the others again in the same request.
     *
     * @var array<string,string|null>|null $headers
     */
    #[Optional(type: new MapOf('string', nullable: true), nullable: true)]
    public ?array $headers;

    /**
     * Whether the destination receives deliveries after the update. The field can't be `null`.
     *
     * @var TelemetryDestinationStateParamsVariants|null $state
     */
    #[Optional(union: TelemetryDestinationStateParams::class)]
    public TelemetryDestinationStateEnabledParams|TelemetryDestinationStateDisabledParams|null $state;

    /**
     * The traces settings to change. Omitted settings keep their stored values.
     *
     * `null` sets every traces setting to its create default.
     */
    #[Optional(nullable: true)]
    public ?TelemetryDestinationTracesParams $traces;

    /**
     * The new workspace scope, in the same form as on create. The field can't be `null`.
     *
     * The API refuses an update that changes the type or sends `workspace_ids` while the destination's list has more than 750 workspaces. Remove workspaces one at a time until 750 or fewer remain, then send the update again.
     *
     * @var TelemetryDestinationWorkspacesParamsVariants|null $workspaces
     */
    #[Optional(union: TelemetryDestinationWorkspacesParams::class)]
    public TelemetryDestinationWorkspacesAllParams|TelemetryDestinationWorkspacesIncludeParams|TelemetryDestinationWorkspacesExcludeParams|null $workspaces;

    /**
     * This endpoint is in beta: requests must send `telemetry-destinations-2026-08-11` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,string|null>|null $headers
     * @param TelemetryDestinationStateParamsShape|null $state
     * @param TelemetryDestinationTracesParams|TelemetryDestinationTracesParamsShape|null $traces
     * @param TelemetryDestinationWorkspacesParamsShape|null $workspaces
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?string $displayName = null,
        ?string $endpointURL = null,
        ?array $headers = null,
        TelemetryDestinationStateEnabledParams|array|TelemetryDestinationStateDisabledParams|null $state = null,
        TelemetryDestinationTracesParams|array|null $traces = null,
        TelemetryDestinationWorkspacesAllParams|array|TelemetryDestinationWorkspacesIncludeParams|TelemetryDestinationWorkspacesExcludeParams|null $workspaces = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $displayName && $self['displayName'] = $displayName;
        null !== $endpointURL && $self['endpointURL'] = $endpointURL;
        null !== $headers && $self['headers'] = $headers;
        null !== $state && $self['state'] = $state;
        null !== $traces && $self['traces'] = $traces;
        null !== $workspaces && $self['workspaces'] = $workspaces;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * New human-readable name, 1 to 255 characters. Null clears it.
     */
    public function withDisplayName(?string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * The new base URL of the destination's OTLP/HTTP endpoint. The same rules as on create apply.
     *
     * A change of hostname or port first removes every registered header, so send the headers for the new endpoint in the same request. When the destination has a `traces.endpoint_url`, such a change must also set `traces.endpoint_url` to a URL with the new hostname and port, or to `null`. A change of the path alone keeps the headers.
     */
    public function withEndpointURL(string $endpointURL): self
    {
        $self = clone $this;
        $self['endpointURL'] = $endpointURL;

        return $self;
    }

    /**
     * Headers to set or remove. The API merges them into the destination's headers by name.
     *
     * Names compare case-insensitively. A string value sets or replaces that header. A `null` value removes it. Headers that you omit don't change. The field itself can't be `null`.
     *
     * A request that sets a header value must also include `endpoint_url`. The current URL is accepted.
     *
     * The resulting set must stay within the same limits as on create. When the request sets a value, each stored value that it doesn't set counts as 4,096 bytes toward the 16,384-byte limit, because you can't read its real length. So to change one header of a destination that has four or more other headers, send the values of the others again in the same request.
     *
     * @param array<string,string|null>|null $headers
     */
    public function withHeaders(?array $headers): self
    {
        $self = clone $this;
        $self['headers'] = $headers;

        return $self;
    }

    /**
     * Whether the destination receives deliveries after the update. The field can't be `null`.
     *
     * @param TelemetryDestinationStateParamsShape $state
     */
    public function withState(
        TelemetryDestinationStateEnabledParams|array|TelemetryDestinationStateDisabledParams $state,
    ): self {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }

    /**
     * The traces settings to change. Omitted settings keep their stored values.
     *
     * `null` sets every traces setting to its create default.
     *
     * @param TelemetryDestinationTracesParams|TelemetryDestinationTracesParamsShape|null $traces
     */
    public function withTraces(
        TelemetryDestinationTracesParams|array|null $traces
    ): self {
        $self = clone $this;
        $self['traces'] = $traces;

        return $self;
    }

    /**
     * The new workspace scope, in the same form as on create. The field can't be `null`.
     *
     * The API refuses an update that changes the type or sends `workspace_ids` while the destination's list has more than 750 workspaces. Remove workspaces one at a time until 750 or fewer remain, then send the update again.
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
