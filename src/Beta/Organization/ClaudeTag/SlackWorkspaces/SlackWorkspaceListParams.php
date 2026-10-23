<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\SlackWorkspaces;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List the set-up Slack workspaces the organization owns, newest first by `created_at`. Pass `slack_workspace_id` to look one workspace up by its Slack identifier: `data` then holds that workspace, or is empty when it is not set up. A workspace of a Slack Enterprise Grid the organization has connected returns 404 until it is set up. With `include_inherited=true` each workspace's `settings` holds what applies in it, and the request fails with 503 rather than resolve against a settings level that could not be read. A `page` cursor resumes only a request with the same `include_inherited`.
 *
 * @see Anthropic\Services\Beta\Organization\ClaudeTag\SlackWorkspacesService::list()
 *
 * @phpstan-type SlackWorkspaceListParamsShape = array{
 *   includeInherited?: bool|null,
 *   limit?: int|null,
 *   page?: string|null,
 *   slackWorkspaceID?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class SlackWorkspaceListParams implements BaseModel
{
    /** @use SdkModel<SlackWorkspaceListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * When `true`, `settings` holds what applies in each workspace once the organization's Slack defaults are taken into account, and every member of `sources` names the level a value comes from. When `false` or left out, `settings` holds what each workspace itself stores.
     */
    #[Optional]
    public ?bool $includeInherited;

    /**
     * Number of items to return per page, between 1 and 100. Defaults to 20.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Opaque cursor from a previous response's `next_page`.
     */
    #[Optional]
    public ?string $page;

    /**
     * Slack's identifier for one workspace, as in the workspace object's `slack.workspace_id`, not its `id`. With it `data` holds that workspace alone, or nothing when it is not set up.
     */
    #[Optional]
    public ?string $slackWorkspaceID;

    /**
     * This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header.
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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?bool $includeInherited = null,
        ?int $limit = null,
        ?string $page = null,
        ?string $slackWorkspaceID = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $includeInherited && $self['includeInherited'] = $includeInherited;
        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;
        null !== $slackWorkspaceID && $self['slackWorkspaceID'] = $slackWorkspaceID;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * When `true`, `settings` holds what applies in each workspace once the organization's Slack defaults are taken into account, and every member of `sources` names the level a value comes from. When `false` or left out, `settings` holds what each workspace itself stores.
     */
    public function withIncludeInherited(bool $includeInherited): self
    {
        $self = clone $this;
        $self['includeInherited'] = $includeInherited;

        return $self;
    }

    /**
     * Number of items to return per page, between 1 and 100. Defaults to 20.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Opaque cursor from a previous response's `next_page`.
     */
    public function withPage(string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Slack's identifier for one workspace, as in the workspace object's `slack.workspace_id`, not its `id`. With it `data` holds that workspace alone, or nothing when it is not set up.
     */
    public function withSlackWorkspaceID(string $slackWorkspaceID): self
    {
        $self = clone $this;
        $self['slackWorkspaceID'] = $slackWorkspaceID;

        return $self;
    }

    /**
     * This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header.
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
