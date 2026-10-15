<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List the organization's destinations, newest first, optionally only those that cover given workspaces.
 *
 * See the [OpenTelemetry export guide](https://platform.claude.com/docs/en/manage-claude/opentelemetry#set-up-api-tracing) to learn more about destinations.
 *
 * @see Anthropic\Services\Beta\Organization\TelemetryDestinationsService::list()
 *
 * @phpstan-type TelemetryDestinationListParamsShape = array{
 *   limit?: int|null,
 *   page?: string|null,
 *   workspaceIDs?: list<string>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class TelemetryDestinationListParams implements BaseModel
{
    /** @use SdkModel<TelemetryDestinationListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Number of destinations to return per page, between 1 and 1,000. Defaults to 20.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Opaque cursor from a previous response's `next_page`. Leave it out to get the first page.
     */
    #[Optional]
    public ?string $page;

    /**
     * Return only the destinations that cover at least one of these workspaces (`wrkspc_...`).
     *
     * Send at most 100 IDs, as `workspace_ids[]`. A destination covers a workspace when its `workspaces.type` is `all`, when its `include` list has the workspace, or when its `exclude` list doesn't have it. Destinations in either state can match. An ID that isn't the ID of one of the organization's workspaces doesn't match any destination, not even one whose type is `all`.
     *
     * @var list<string>|null $workspaceIDs
     */
    #[Optional(list: 'string')]
    public ?array $workspaceIDs;

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
     * @param list<string>|null $workspaceIDs
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?int $limit = null,
        ?string $page = null,
        ?array $workspaceIDs = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;
        null !== $workspaceIDs && $self['workspaceIDs'] = $workspaceIDs;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Number of destinations to return per page, between 1 and 1,000. Defaults to 20.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Opaque cursor from a previous response's `next_page`. Leave it out to get the first page.
     */
    public function withPage(string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Return only the destinations that cover at least one of these workspaces (`wrkspc_...`).
     *
     * Send at most 100 IDs, as `workspace_ids[]`. A destination covers a workspace when its `workspaces.type` is `all`, when its `include` list has the workspace, or when its `exclude` list doesn't have it. Destinations in either state can match. An ID that isn't the ID of one of the organization's workspaces doesn't match any destination, not even one whose type is `all`.
     *
     * @param list<string> $workspaceIDs
     */
    public function withWorkspaceIDs(array $workspaceIDs): self
    {
        $self = clone $this;
        $self['workspaceIDs'] = $workspaceIDs;

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
