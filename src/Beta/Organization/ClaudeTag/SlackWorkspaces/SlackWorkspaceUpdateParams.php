<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\SlackWorkspaces;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsUpdate;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Change the settings a Slack workspace stores. The update is partial: a setting left out is unchanged, and a setting sent as null is cleared, so the workspace inherits it. If any value is refused, no setting in the request is stored.
 *
 * @see Anthropic\Services\Beta\Organization\ClaudeTag\SlackWorkspacesService::update()
 *
 * @phpstan-import-type ClaudeTagSettingsUpdateShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsUpdate
 *
 * @phpstan-type SlackWorkspaceUpdateParamsShape = array{
 *   settings: ClaudeTagSettingsUpdate|ClaudeTagSettingsUpdateShape,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class SlackWorkspaceUpdateParams implements BaseModel
{
    /** @use SdkModel<SlackWorkspaceUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The settings to change.
     */
    #[Required]
    public ClaudeTagSettingsUpdate $settings;

    /**
     * This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new SlackWorkspaceUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SlackWorkspaceUpdateParams::with(settings: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SlackWorkspaceUpdateParams())->withSettings(...)
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
     * @param ClaudeTagSettingsUpdate|ClaudeTagSettingsUpdateShape $settings
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ClaudeTagSettingsUpdate|array $settings,
        ?array $betas = null
    ): self {
        $self = new self;

        $self['settings'] = $settings;

        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * The settings to change.
     *
     * @param ClaudeTagSettingsUpdate|ClaudeTagSettingsUpdateShape $settings
     */
    public function withSettings(ClaudeTagSettingsUpdate|array $settings): self
    {
        $self = clone $this;
        $self['settings'] = $settings;

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
