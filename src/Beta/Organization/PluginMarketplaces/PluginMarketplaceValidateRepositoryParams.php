<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\PluginMarketplaces;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Check whether a plugin marketplace held in a public GitHub repository would
 * synchronize into claude.ai, without connecting or storing it.
 *
 * To check a `.zip` of the marketplace directory instead, use Validate Plugin Marketplace Archive.
 *
 * The report says whether `marketplace.json` is well-formed, which plugins a
 * synchronization would skip and why, and which plugins would synchronize only in
 * part, with some files left out. A repository that is missing, private, or has no such branch or commit is reported, not refused: the response is a report with `valid: false`. Plugin sources outside the marketplace
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
 * @see Anthropic\Services\Beta\Organization\PluginMarketplacesService::validateRepository()
 *
 * @phpstan-type PluginMarketplaceValidateRepositoryParamsShape = array{
 *   repositoryURL: string,
 *   ref?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class PluginMarketplaceValidateRepositoryParams implements BaseModel
{
    /** @use SdkModel<PluginMarketplaceValidateRepositoryParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The `https://` URL of a public repository on github.com that holds the marketplace. Any other host, a URL with credentials in it, or one that does not name a repository is a 400.
     */
    #[Required('repository_url')]
    public string $repositoryURL;

    /**
     * The branch to validate the tip of, or the full 40-character SHA of the commit to validate. When omitted, the branch a synchronization would read (usually the repository's default branch); if that is not the default branch, the report's `ref` says which branch was read. An empty string, or a value that is neither a branch name nor a 40-character SHA, is a 400.
     */
    #[Optional(nullable: true)]
    public ?string $ref;

    /**
     * This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new PluginMarketplaceValidateRepositoryParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PluginMarketplaceValidateRepositoryParams::with(repositoryURL: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PluginMarketplaceValidateRepositoryParams)->withRepositoryURL(...)
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
        string $repositoryURL,
        ?string $ref = null,
        ?array $betas = null
    ): self {
        $self = new self;

        $self['repositoryURL'] = $repositoryURL;

        null !== $ref && $self['ref'] = $ref;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * The `https://` URL of a public repository on github.com that holds the marketplace. Any other host, a URL with credentials in it, or one that does not name a repository is a 400.
     */
    public function withRepositoryURL(string $repositoryURL): self
    {
        $self = clone $this;
        $self['repositoryURL'] = $repositoryURL;

        return $self;
    }

    /**
     * The branch to validate the tip of, or the full 40-character SHA of the commit to validate. When omitted, the branch a synchronization would read (usually the repository's default branch); if that is not the default branch, the report's `ref` says which branch was read. An empty string, or a value that is neither a branch name nor a 40-character SHA, is a 400.
     */
    public function withRef(?string $ref): self
    {
        $self = clone $this;
        $self['ref'] = $ref;

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
