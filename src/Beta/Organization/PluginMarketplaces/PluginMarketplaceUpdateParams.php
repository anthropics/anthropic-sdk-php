<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\PluginMarketplaces;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceUpdateParams\DefaultInstallationPreference;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Set the default installation setting of one of the organization's own plugin
 * marketplaces. Every Plugin in it without a setting of its own gets this default as
 * its organization-wide setting, including Plugins added later.
 *
 * Pass it as `default_installation_preference`. A member's personal marketplace
 * cannot be updated here (403).
 *
 * **Accepted credentials:** an Admin API key with the `write:plugins` scope.
 *
 * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
 *
 * @see Anthropic\Services\Beta\Organization\PluginMarketplacesService::update()
 *
 * @phpstan-type PluginMarketplaceUpdateParamsShape = array{
 *   defaultInstallationPreference: DefaultInstallationPreference|value-of<DefaultInstallationPreference>,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class PluginMarketplaceUpdateParams implements BaseModel
{
    /** @use SdkModel<PluginMarketplaceUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The organization-wide installation setting every Plugin in the marketplace without one of its own gets: one of `required`, `auto_install`, `available`, `not_available`. Once set it can be changed but not removed.
     *
     * @var value-of<DefaultInstallationPreference> $defaultInstallationPreference
     */
    #[Required(
        'default_installation_preference',
        enum: DefaultInstallationPreference::class,
    )]
    public string $defaultInstallationPreference;

    /**
     * This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new PluginMarketplaceUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PluginMarketplaceUpdateParams::with(defaultInstallationPreference: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PluginMarketplaceUpdateParams())->withDefaultInstallationPreference(...)
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
     * @param DefaultInstallationPreference|value-of<DefaultInstallationPreference> $defaultInstallationPreference
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        DefaultInstallationPreference|string $defaultInstallationPreference,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['defaultInstallationPreference'] = $defaultInstallationPreference;

        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * The organization-wide installation setting every Plugin in the marketplace without one of its own gets: one of `required`, `auto_install`, `available`, `not_available`. Once set it can be changed but not removed.
     *
     * @param DefaultInstallationPreference|value-of<DefaultInstallationPreference> $defaultInstallationPreference
     */
    public function withDefaultInstallationPreference(
        DefaultInstallationPreference|string $defaultInstallationPreference
    ): self {
        $self = clone $this;
        $self['defaultInstallationPreference'] = $defaultInstallationPreference;

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
