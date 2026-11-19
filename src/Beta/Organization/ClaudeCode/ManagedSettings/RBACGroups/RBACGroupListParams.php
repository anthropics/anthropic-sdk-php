<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List the RBAC Groups that have Claude Code managed settings, highest precedence first.
 *
 * Each entry gives the group's status and timestamps, not its settings. The list includes deleted groups that still have settings, and leaves out the default settings. If the order changes between pages, the request returns `409`: list again from the first page.
 *
 * **Accepted credentials:** an organization-level Admin API key with the `read:claude_code_managed_settings` scope.
 *
 * Every request must include the beta header `anthropic-beta: ce-claude-code-managed-settings-2026-10-06`. A request without it, or from an organization not enabled for this beta, returns `404`. The Claude Code Managed Settings API is in beta and is available to Claude Enterprise organizations only.
 *
 * @see Anthropic\Services\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroupsService::list()
 *
 * @phpstan-type RBACGroupListParamsShape = array{
 *   limit?: int|null,
 *   page?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class RBACGroupListParams implements BaseModel
{
    /** @use SdkModel<RBACGroupListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `100`.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Optionally set to the `next_page` token from the previous response.
     */
    #[Optional(nullable: true)]
    public ?string $page;

    /**
     * This endpoint is in beta: requests must send `ce-claude-code-managed-settings-2026-10-06` in this header.
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
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null
    ): self {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `100`.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Optionally set to the `next_page` token from the previous response.
     */
    public function withPage(?string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * This endpoint is in beta: requests must send `ce-claude-code-managed-settings-2026-10-06` in this header.
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
