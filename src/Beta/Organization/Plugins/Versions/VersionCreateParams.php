<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\Versions;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\FileParam;

/**
 * Add a version to an organization-owned Plugin by uploading the new version's
 * files; it becomes the version served to members unless the Plugin's served version
 * has been pinned.
 *
 * The upload is the same `multipart/form-data` as creating a Plugin: the version's
 * files (`files`, each part sent as `files[]`) and optional `release_notes`. The uploaded manifest's `name`
 * must equal the Plugin's `name`. Returns the stored version; read the Plugin back to
 * see which version it serves.
 *
 * Only a Plugin in a `manual` marketplace takes uploads; a Plugin synchronized from
 * a repository gets its versions from the repository. When the Plugin is in the
 * organization's library marketplace, a version that adds a skill with the name of an
 * organization skill (a skill an administrator uploaded for the whole organization in
 * claude.ai) is refused with a 409: `error_code` `skill_name_taken`, with that name in
 * `details.skill_name`. A 503 with `error_code`
 * `registration_pending` means the version was stored but is not yet usable; a later
 * version create on the Plugin completes it.
 *
 * For a worked example, see [Create a version](/docs/en/manage-claude/plugins-api#create-a-version)
 * in the Plugins API guide.
 *
 * **Accepted credentials:** an Admin API key with the `write:plugins` scope.
 *
 * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
 *
 * @see Anthropic\Services\Beta\Organization\Plugins\VersionsService::create()
 *
 * @phpstan-type VersionCreateParamsShape = array{
 *   files: list<string|FileParam>,
 *   releaseNotes?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class VersionCreateParams implements BaseModel
{
    /** @use SdkModel<VersionCreateParamsShape> */
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
     * `new VersionCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * VersionCreateParams::with(files: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new VersionCreateParams)->withFiles(...)
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
        ?string $releaseNotes = null,
        ?array $betas = null
    ): self {
        $self = new self;

        $self['files'] = $files;

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
