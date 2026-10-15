<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\TelemetryDestinations\DeletedTelemetryDestination;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestination;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationStateDisabledParams;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationStateEnabledParams;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationTestResponse;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationTracesParams;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationWorkspacesAllParams;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationWorkspacesExcludeParams;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationWorkspacesIncludeParams;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type TelemetryDestinationWorkspacesParamsShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationWorkspacesParams
 * @phpstan-import-type TelemetryDestinationTracesParamsShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationTracesParams
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type TelemetryDestinationStateParamsShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationStateParams
 */
interface TelemetryDestinationsContract
{
    /**
     * @api
     *
     * @param string $endpointURL Body param: The base URL of your collector's OTLP/HTTP endpoint, for example `https://gateway.example.com`.
     *
     * The URL must use `https` and a hostname, not an IP address. The port, if given, must be 443. The URL must not contain a query string, a fragment, or a username and password. At most 2,048 characters.
     *
     * A path prefix, such as `/otlp`, is allowed. Don't include the per-signal path (`/v1/traces`), because the API appends it on delivery. If your collector takes traces on another path, also set `traces.endpoint_url`.
     * @param TelemetryDestinationWorkspacesParamsShape $workspaces body param: Which of the organization's workspaces the destination covers
     * @param string|null $displayName Body param: Human-readable name for the destination. Optional. 1 to 255 characters.
     * @param array<string,string> $headers Body param: Request headers that the API sends with every delivery, typically your collector's authentication header (for example `authorization`).
     *
     * The API stores the values encrypted and never returns them. Reads show only `header_names`.
     *
     * At most 20 headers. Names are at most 128 characters. Two names can't differ only in case. Values are printable ASCII, at most 4,096 characters, and can't begin or end with a space. Names and values together are at most 16,384 bytes.
     *
     * Reserved names are rejected, for example `host`, `cookie`, `user-agent`, and names that start with `content-`, `proxy-`, `x-forwarded-`, or `anthropic-`. For this check, `_` in a name counts as `-`.
     * @param TelemetryDestinationTracesParams|TelemetryDestinationTracesParamsShape $traces Body param: The settings for the traces that the destination receives. If you leave it out, every setting takes its default.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `telemetry-destinations-2026-08-11` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $endpointURL,
        TelemetryDestinationWorkspacesAllParams|array|TelemetryDestinationWorkspacesIncludeParams|TelemetryDestinationWorkspacesExcludeParams $workspaces,
        ?string $displayName = null,
        ?array $headers = null,
        TelemetryDestinationTracesParams|array|null $traces = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): TelemetryDestination;

    /**
     * @api
     *
     * @param string $destinationID ID of the destination (`tdst_...`).
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas this endpoint is in beta: requests must send `telemetry-destinations-2026-08-11` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $destinationID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): TelemetryDestination;

    /**
     * @api
     *
     * @param string $destinationID Path param: ID of the destination (`tdst_...`).
     * @param string|null $displayName Body param: New human-readable name, 1 to 255 characters. Null clears it.
     * @param string $endpointURL Body param: The new base URL of the destination's OTLP/HTTP endpoint. The same rules as on create apply.
     *
     * A change of hostname or port first removes every registered header, so send the headers for the new endpoint in the same request. When the destination has a `traces.endpoint_url`, such a change must also set `traces.endpoint_url` to a URL with the new hostname and port, or to `null`. A change of the path alone keeps the headers.
     * @param array<string,string|null>|null $headers Body param: Headers to set or remove. The API merges them into the destination's headers by name.
     *
     * Names compare case-insensitively. A string value sets or replaces that header. A `null` value removes it. Headers that you omit don't change. The field itself can't be `null`.
     *
     * A request that sets a header value must also include `endpoint_url`. The current URL is accepted.
     *
     * The resulting set must stay within the same limits as on create. When the request sets a value, each stored value that it doesn't set counts as 4,096 bytes toward the 16,384-byte limit, because you can't read its real length. So to change one header of a destination that has four or more other headers, send the values of the others again in the same request.
     * @param TelemetryDestinationStateParamsShape $state Body param: Whether the destination receives deliveries after the update. The field can't be `null`.
     * @param TelemetryDestinationTracesParams|TelemetryDestinationTracesParamsShape|null $traces Body param: The traces settings to change. Omitted settings keep their stored values.
     *
     * `null` sets every traces setting to its create default.
     * @param TelemetryDestinationWorkspacesParamsShape $workspaces Body param: The new workspace scope, in the same form as on create. The field can't be `null`.
     *
     * The API refuses an update that changes the type or sends `workspace_ids` while the destination's list has more than 750 workspaces. Remove workspaces one at a time until 750 or fewer remain, then send the update again.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `telemetry-destinations-2026-08-11` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $destinationID,
        ?string $displayName = null,
        ?string $endpointURL = null,
        ?array $headers = null,
        TelemetryDestinationStateEnabledParams|array|TelemetryDestinationStateDisabledParams|null $state = null,
        TelemetryDestinationTracesParams|array|null $traces = null,
        TelemetryDestinationWorkspacesAllParams|array|TelemetryDestinationWorkspacesIncludeParams|TelemetryDestinationWorkspacesExcludeParams|null $workspaces = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): TelemetryDestination;

    /**
     * @api
     *
     * @param int $limit Query param: Number of destinations to return per page, between 1 and 1,000. Defaults to 20.
     * @param string $page Query param: Opaque cursor from a previous response's `next_page`. Leave it out to get the first page.
     * @param list<string> $workspaceIDs Query param: Return only the destinations that cover at least one of these workspaces (`wrkspc_...`).
     *
     * Send at most 100 IDs, as `workspace_ids[]`. A destination covers a workspace when its `workspaces.type` is `all`, when its `include` list has the workspace, or when its `exclude` list doesn't have it. Destinations in either state can match. An ID that isn't the ID of one of the organization's workspaces doesn't match any destination, not even one whose type is `all`.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `telemetry-destinations-2026-08-11` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<TelemetryDestination>
     *
     * @throws APIException
     */
    public function list(
        ?int $limit = null,
        ?string $page = null,
        ?array $workspaceIDs = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $destinationID ID of the destination (`tdst_...`).
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas this endpoint is in beta: requests must send `telemetry-destinations-2026-08-11` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $destinationID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): DeletedTelemetryDestination;

    /**
     * @api
     *
     * @param string $destinationID ID of the destination to test (starts with `tdst_`)
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas this endpoint is in beta: requests must send `telemetry-destinations-2026-08-11` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function test(
        string $destinationID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): TelemetryDestinationTestResponse;
}
