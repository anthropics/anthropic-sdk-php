<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\SlackWorkspaces;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Get one Slack workspace and its settings. By default `settings` holds what the workspace itself stores: a setting that is null there is not set on the workspace and is inherited. With `include_inherited=true`, `settings` holds what applies in the workspace once the organization's Slack defaults are taken into account, and the request fails with 503 rather than resolve against a settings level that could not be read. Either way `sources` names the settings level each value comes from.
 *
 * @see Anthropic\Services\Beta\Organization\ClaudeTag\SlackWorkspacesService::retrieve()
 *
 * @phpstan-type SlackWorkspaceRetrieveParamsShape = array{
 *   includeInherited?: bool|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class SlackWorkspaceRetrieveParams implements BaseModel
{
    /** @use SdkModel<SlackWorkspaceRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * When `true`, `settings` holds what applies in the workspace once the organization's Slack defaults are taken into account, and every member of `sources` names the level a value comes from. When `false` or left out, `settings` holds what the workspace itself stores.
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
     * When `true`, `settings` holds what applies in the workspace once the organization's Slack defaults are taken into account, and every member of `sources` names the level a value comes from. When `false` or left out, `settings` holds what the workspace itself stores.
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
