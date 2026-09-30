<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Permanently delete a Plugin and every version it holds, exactly as when an
 * administrator deletes it in claude.ai. The Plugin may belong to the organization or
 * to a member, including a member who has since left the organization.
 *
 * An organization-owned Plugin's installation settings go with it; a member-owned
 * Plugin's shares are withdrawn and its owner no longer has it.
 *
 * To take an organization-owned Plugin out of use reversibly, set its
 * organization-wide installation setting to `not_available` instead (and
 * remove or change any group settings, which override it for their members). Only a
 * Plugin in a `manual` marketplace can be deleted here; one synchronized from a
 * repository is removed by removing it from the repository (400).
 *
 * **Accepted credentials:** an Admin API key with the `write:plugins` scope.
 *
 * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
 *
 * @see Anthropic\Services\Beta\Organization\PluginsService::delete()
 *
 * @phpstan-type PluginDeleteParamsShape = array{
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null
 * }
 */
final class PluginDeleteParams implements BaseModel
{
    /** @use SdkModel<PluginDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header.
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
    public static function with(?array $betas = null): self
    {
        $self = new self;

        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header.
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
