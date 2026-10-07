<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\FileParam;

/**
 * Create an organization-owned Plugin and its first version by uploading the
 * version's files.
 *
 * The upload is `multipart/form-data`: the version's files (`files`, each part sent
 * as `files[]`), with an optional `marketplace_id` and `release_notes`. The manifest's `name` becomes the
 * Plugin's `name`, and `display_name`, `description` and `manifest_version` come
 * from the manifest too.
 *
 * `name` may contain lowercase letters (from any alphabet), digits, and hyphens, up
 * to 64 characters. Uppercase letters, spaces, underscores, and other punctuation are
 * rejected.
 *
 * The `name` must be unique within the marketplace: a name already taken
 * returns a 409 with `error_code` `plugin_name_taken` and, when a Plugin holds it,
 * that Plugin's ID in `details.plugin_id`. A Plugin going into the organization's
 * library marketplace is also refused with a 409 when one of its skills has the name of
 * an organization skill (a skill an administrator uploaded for the whole organization
 * in claude.ai): `error_code` `skill_name_taken`, with that name in
 * `details.skill_name`; rename the skill, or remove the organization skill in
 * claude.ai. A 503 with `error_code`
 * `registration_pending` means the Plugin and its version were stored (their IDs are
 * in `details`) but are not yet usable in claude.ai: do not retry the create (the
 * retry would return `plugin_name_taken`); create a version on the stored Plugin
 * instead, which completes it.
 *
 * For a worked example, see [Create a plugin](/docs/en/manage-claude/plugins-api#create-a-plugin)
 * in the Plugins API guide.
 *
 * **Accepted credentials:** an Admin API key with the `write:plugins` scope.
 *
 * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
 *
 * @see Anthropic\Services\Beta\Organization\PluginsService::create()
 *
 * @phpstan-type PluginCreateParamsShape = array{
 *   files: list<string|FileParam>,
 *   marketplaceID?: string|null,
 *   releaseNotes?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class PluginCreateParams implements BaseModel
{
    /** @use SdkModel<PluginCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The version's files: one part per file, the part's filename being the file's path within the Plugin (for example `skills/review-pr/SKILL.md`), or a single `.zip` or `.plugin` archive holding them all. On the wire each part is named `files[]`, and a part named plain `files` is not read; with cURL, `-F 'files[]=@SKILL.md;filename=skills/review-pr/SKILL.md'`. The files must include the manifest, `.claude-plugin/plugin.json`.
     *
     * @var list<string> $files
     */
    #[Required(list: FileParam::class)]
    public array $files;

    /**
     * ID of the organization-owned plugin marketplace to create the Plugin in (prefixed `marketplace_`). It must be a `manual` marketplace, one whose Plugins are uploaded rather than synchronized from a repository. When omitted, the Plugin is created in the organization's library marketplace, an organization-owned `manual` marketplace created on first use.
     */
    #[Optional('marketplace_id')]
    public ?string $marketplaceID;

    /**
     * Release notes stored with the version and shown in its version history in claude.ai; up to 5,000 characters.
     */
    #[Optional('release_notes')]
    public ?string $releaseNotes;

    /**
     * This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new PluginCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PluginCreateParams::with(files: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PluginCreateParams())->withFiles(...)
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
     * @param list<string|FileParam> $files
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        array $files,
        ?string $marketplaceID = null,
        ?string $releaseNotes = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['files'] = $files;

        null !== $marketplaceID && $self['marketplaceID'] = $marketplaceID;
        null !== $releaseNotes && $self['releaseNotes'] = $releaseNotes;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * The version's files: one part per file, the part's filename being the file's path within the Plugin (for example `skills/review-pr/SKILL.md`), or a single `.zip` or `.plugin` archive holding them all. On the wire each part is named `files[]`, and a part named plain `files` is not read; with cURL, `-F 'files[]=@SKILL.md;filename=skills/review-pr/SKILL.md'`. The files must include the manifest, `.claude-plugin/plugin.json`.
     *
     * @param list<string|FileParam> $files
     */
    public function withFiles(array $files): self
    {
        $self = clone $this;
        $self['files'] = $files;

        return $self;
    }

    /**
     * ID of the organization-owned plugin marketplace to create the Plugin in (prefixed `marketplace_`). It must be a `manual` marketplace, one whose Plugins are uploaded rather than synchronized from a repository. When omitted, the Plugin is created in the organization's library marketplace, an organization-owned `manual` marketplace created on first use.
     */
    public function withMarketplaceID(string $marketplaceID): self
    {
        $self = clone $this;
        $self['marketplaceID'] = $marketplaceID;

        return $self;
    }

    /**
     * Release notes stored with the version and shown in its version history in claude.ai; up to 5,000 characters.
     */
    public function withReleaseNotes(string $releaseNotes): self
    {
        $self = clone $this;
        $self['releaseNotes'] = $releaseNotes;

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
