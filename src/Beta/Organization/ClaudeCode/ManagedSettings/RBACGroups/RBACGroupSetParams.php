<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Create or replace an RBAC Group's Claude Code managed settings.
 *
 * New settings join the end of `rbac_group_order`, and existing settings keep their place. Until the group is moved up, its members who also belong to an earlier group keep that group's settings. In `organization` mode a write changes no member's settings until the organization switches to `rbac_groups` mode. Once a group has settings, that switch no longer copies the organization settings into default settings, so members in no RBAC Group in `rbac_group_order` receive no settings unless you set the default settings before the switch.
 *
 * Get the group's ID from the RBAC Groups API. One key can hold `read:rbac_groups` and `write:claude_code_managed_settings`.
 *
 * **Accepted credentials:** an organization-level Admin API key with the `write:claude_code_managed_settings` scope.
 *
 * Every request must include the beta header `anthropic-beta: ce-claude-code-managed-settings-2026-10-06`. A request without it, or from an organization not enabled for this beta, returns `404`. The Claude Code Managed Settings API is in beta and is available to Claude Enterprise organizations only.
 *
 * A write that returns `503` may have applied. Retrying it is safe.
 *
 * @see Anthropic\Services\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroupsService::set()
 *
 * @phpstan-type RBACGroupSetParamsShape = array{
 *   settings: array<string,mixed>,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class RBACGroupSetParams implements BaseModel
{
    /** @use SdkModel<RBACGroupSetParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The whole settings document, a JSON object of Claude Code managed settings. It replaces any stored document. At most 1 MiB as the server stores it, which can be larger than the request body.
     *
     * @var array<string,mixed> $settings
     */
    #[Required(map: 'mixed')]
    public array $settings;

    /**
     * This endpoint is in beta: requests must send `ce-claude-code-managed-settings-2026-10-06` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new RBACGroupSetParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RBACGroupSetParams::with(settings: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RBACGroupSetParams())->withSettings(...)
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
     * @param array<string,mixed> $settings
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(array $settings, ?array $betas = null): self
    {
        $self = new self;

        $self['settings'] = $settings;

        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * The whole settings document, a JSON object of Claude Code managed settings. It replaces any stored document. At most 1 MiB as the server stores it, which can be larger than the request body.
     *
     * @param array<string,mixed> $settings
     */
    public function withSettings(array $settings): self
    {
        $self = clone $this;
        $self['settings'] = $settings;

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
