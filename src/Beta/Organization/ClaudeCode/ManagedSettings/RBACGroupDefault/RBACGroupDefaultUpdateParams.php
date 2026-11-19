<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroupDefault;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Set or replace the default Claude Code managed settings, or clear them with `null`.
 *
 * **Accepted credentials:** an organization-level Admin API key with the `write:claude_code_managed_settings` scope.
 *
 * Every request must include the beta header `anthropic-beta: ce-claude-code-managed-settings-2026-10-06`. A request without it, or from an organization not enabled for this beta, returns `404`. The Claude Code Managed Settings API is in beta and is available to Claude Enterprise organizations only.
 *
 * A write that returns `503` may have applied. Retrying it is safe.
 *
 * @see Anthropic\Services\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroupDefaultService::update()
 *
 * @phpstan-type RBACGroupDefaultUpdateParamsShape = array{
 *   settings: array<string,mixed>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class RBACGroupDefaultUpdateParams implements BaseModel
{
    /** @use SdkModel<RBACGroupDefaultUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The whole settings document, a JSON object of Claude Code managed settings. It replaces any stored document, or `null` clears the default settings. At most 1 MiB as the server stores it, which can be larger than the request body.
     *
     * @var array<string,mixed>|null $settings
     */
    #[Required(map: 'mixed')]
    public ?array $settings;

    /**
     * This endpoint is in beta: requests must send `ce-claude-code-managed-settings-2026-10-06` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new RBACGroupDefaultUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RBACGroupDefaultUpdateParams::with(settings: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RBACGroupDefaultUpdateParams())->withSettings(...)
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
     * @param array<string,mixed>|null $settings
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(?array $settings, ?array $betas = null): self
    {
        $self = new self;

        $self['settings'] = $settings;

        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * The whole settings document, a JSON object of Claude Code managed settings. It replaces any stored document, or `null` clears the default settings. At most 1 MiB as the server stores it, which can be larger than the request body.
     *
     * @param array<string,mixed>|null $settings
     */
    public function withSettings(?array $settings): self
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
