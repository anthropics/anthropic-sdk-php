<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\SlackChannels;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsUpdate;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Change the settings a Slack channel stores. The update is partial: a setting left out is unchanged, and a setting sent as null is cleared, so the channel inherits it. If any value is refused, no setting in the request is stored. A group direct message takes no settings and returns 400.
 *
 * @see Anthropic\Services\Beta\Organization\ClaudeTag\SlackChannelsService::update()
 *
 * @phpstan-import-type ClaudeTagSettingsUpdateShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsUpdate
 *
 * @phpstan-type SlackChannelUpdateParamsShape = array{
 *   settings: ClaudeTagSettingsUpdate|ClaudeTagSettingsUpdateShape,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class SlackChannelUpdateParams implements BaseModel
{
    /** @use SdkModel<SlackChannelUpdateParamsShape> */
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
     * `new SlackChannelUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SlackChannelUpdateParams::with(settings: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SlackChannelUpdateParams())->withSettings(...)
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
