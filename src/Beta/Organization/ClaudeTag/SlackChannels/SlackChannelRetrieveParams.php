<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\SlackChannels;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Get one Slack channel and its settings. By default `settings` holds what the channel itself stores: a setting that is null there is not set on the channel and is inherited. With `include_inherited=true`, `settings` holds what applies in the channel once the settings levels above it are taken into account, and the request fails with 503 rather than resolve against a settings level that could not be read. Either way `sources` names the settings level each value comes from, so a caller tells the channel's own value from an inherited one by its source, not by whether it is null.
 *
 * @see Anthropic\Services\Beta\Organization\ClaudeTag\SlackChannelsService::retrieve()
 *
 * @phpstan-type SlackChannelRetrieveParamsShape = array{
 *   includeInherited?: bool|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class SlackChannelRetrieveParams implements BaseModel
{
    /** @use SdkModel<SlackChannelRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * When `true`, `settings` holds what applies in the channel once the settings levels above it are taken into account, and every member of `sources` names the level a value comes from. When `false` or left out, `settings` holds what the channel itself stores.
     */
    #[Optional]
    public ?bool $includeInherited;

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
        ?array $betas = null
    ): self {
        $self = new self;

        null !== $includeInherited && $self['includeInherited'] = $includeInherited;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * When `true`, `settings` holds what applies in the channel once the settings levels above it are taken into account, and every member of `sources` names the level a value comes from. When `false` or left out, `settings` holds what the channel itself stores.
     */
    public function withIncludeInherited(bool $includeInherited): self
    {
        $self = clone $this;
        $self['includeInherited'] = $includeInherited;

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
