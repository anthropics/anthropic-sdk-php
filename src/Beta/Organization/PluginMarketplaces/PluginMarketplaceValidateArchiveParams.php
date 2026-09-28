<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\PluginMarketplaces;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\FileParam;

/**
 * Check whether a plugin marketplace, uploaded as a `.zip` of the marketplace
 * directory, would synchronize into claude.ai, without connecting or storing it.
 *
 * To check a public GitHub repository instead, use Validate Plugin Marketplace Repository.
 *
 * The report says whether `marketplace.json` is well-formed, which plugins a
 * synchronization would skip and why, and which plugins would synchronize only in
 * part, with some files left out. An archive that cannot be read as a marketplace is reported, not refused: the response is a report with `valid: false`. Plugin sources outside the marketplace
 * are fetched anonymously from GitHub, so a private one is reported as not found; a
 * source on any other host is not fetched here, and the report notes that it will be
 * checked when the marketplace actually synchronizes.
 *
 * Nothing is recorded on the Compliance API activity feed.
 *
 * For a worked example, see [Validate marketplace content](/docs/en/manage-claude/plugins-api#validate-marketplace-content)
 * in the Plugins API guide.
 *
 * **Accepted credentials:** an Admin API key with the `read:plugins` or `write:plugins` scope; `read:org_audit` and `read:compliance_org_data` do not grant it.
 *
 * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
 *
 * @see Anthropic\Services\Beta\Organization\PluginMarketplacesService::validateArchive()
 *
 * @phpstan-type PluginMarketplaceValidateArchiveParamsShape = array{
 *   archive: string|FileParam,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class PluginMarketplaceValidateArchiveParams implements BaseModel
{
    /** @use SdkModel<PluginMarketplaceValidateArchiveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * A .zip of the marketplace directory (its contents at the root, or wrapped in one folder as a Git host's download produces), sent as a file part with a filename; DEFLATE- or STORE-compressed, at most 32 MB. A part sent without a filename, a second archive part, or any other form field is a 400; a larger archive is a 413.
     */
    #[Required]
    public string $archive;

    /**
     * This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new PluginMarketplaceValidateArchiveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PluginMarketplaceValidateArchiveParams::with(archive: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PluginMarketplaceValidateArchiveParams)->withArchive(...)
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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        string|FileParam $archive,
        ?array $betas = null
    ): self {
        $self = new self;

        $self['archive'] = $archive;

        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * A .zip of the marketplace directory (its contents at the root, or wrapped in one folder as a Git host's download produces), sent as a file part with a filename; DEFLATE- or STORE-compressed, at most 32 MB. A part sent without a filename, a second archive part, or any other form field is a 400; a larger archive is a 413.
     */
    public function withArchive(string|FileParam $archive): self
    {
        $self = clone $this;
        $self['archive'] = $archive;

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
