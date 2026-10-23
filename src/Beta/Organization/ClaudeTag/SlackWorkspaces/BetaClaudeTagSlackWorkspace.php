<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\SlackWorkspaces;

use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettings;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingSources;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSlackWorkspaceIdentifiers;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A Slack workspace the organization has connected, itself or through its Slack Enterprise Grid, with the settings it stores or, with `include_inherited`, the settings that apply in it.
 *
 * @phpstan-import-type ClaudeTagSettingsShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettings
 * @phpstan-import-type ClaudeTagSlackWorkspaceIdentifiersShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSlackWorkspaceIdentifiers
 * @phpstan-import-type ClaudeTagSettingSourcesShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingSources
 *
 * @phpstan-type BetaClaudeTagSlackWorkspaceShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   settings: ClaudeTagSettings|ClaudeTagSettingsShape,
 *   slack: ClaudeTagSlackWorkspaceIdentifiers|ClaudeTagSlackWorkspaceIdentifiersShape,
 *   sources: ClaudeTagSettingSources|ClaudeTagSettingSourcesShape,
 *   type: 'slack_workspace',
 *   updatedAt: \DateTimeInterface,
 * }
 */
final class BetaClaudeTagSlackWorkspace implements BaseModel
{
    /** @use SdkModel<BetaClaudeTagSlackWorkspaceShape> */
    use SdkModel;

    /** @var 'slack_workspace' $type */
    #[Required(type: new ConstantOf('slack_workspace'))]
    public string $type = 'slack_workspace';

    /**
     * The workspace's identifier. Starts with `slws_`. It does not change for as long as the workspace is set up. A workspace that is removed and set up again has a new one, and the old one keeps returning 404; look the workspace up by its Slack identifier for the new one.
     */
    #[Required]
    public string $id;

    /**
     * Time the workspace was set up, by whichever route. It does not change for as long as `id` does not.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * What the workspace itself stores or, with `include_inherited`, what applies in it. `sources` says which.
     */
    #[Required]
    public ClaudeTagSettings $settings;

    /**
     * Slack's own identifier for the workspace.
     */
    #[Required]
    public ClaudeTagSlackWorkspaceIdentifiers $slack;

    /**
     * For each setting, the settings level its value in `settings` comes from.
     */
    #[Required]
    public ClaudeTagSettingSources $sources;

    /**
     * Time Claude Tag's record of the workspace last changed. It moves on every change to a setting, and can also move when something no response holds changes, so a later value says to read the workspace again, not that a setting changed. Attaching or detaching a Bundle does not by itself move it.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * `new BetaClaudeTagSlackWorkspace()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaClaudeTagSlackWorkspace::with(
     *   id: ...,
     *   createdAt: ...,
     *   settings: ...,
     *   slack: ...,
     *   sources: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaClaudeTagSlackWorkspace())
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withSettings(...)
     *   ->withSlack(...)
     *   ->withSources(...)
     *   ->withUpdatedAt(...)
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
     * @param ClaudeTagSettings|ClaudeTagSettingsShape $settings
     * @param ClaudeTagSlackWorkspaceIdentifiers|ClaudeTagSlackWorkspaceIdentifiersShape $slack
     * @param ClaudeTagSettingSources|ClaudeTagSettingSourcesShape $sources
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        ClaudeTagSettings|array $settings,
        ClaudeTagSlackWorkspaceIdentifiers|array $slack,
        ClaudeTagSettingSources|array $sources,
        \DateTimeInterface $updatedAt,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['settings'] = $settings;
        $self['slack'] = $slack;
        $self['sources'] = $sources;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * The workspace's identifier. Starts with `slws_`. It does not change for as long as the workspace is set up. A workspace that is removed and set up again has a new one, and the old one keeps returning 404; look the workspace up by its Slack identifier for the new one.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Time the workspace was set up, by whichever route. It does not change for as long as `id` does not.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * What the workspace itself stores or, with `include_inherited`, what applies in it. `sources` says which.
     *
     * @param ClaudeTagSettings|ClaudeTagSettingsShape $settings
     */
    public function withSettings(ClaudeTagSettings|array $settings): self
    {
        $self = clone $this;
        $self['settings'] = $settings;

        return $self;
    }

    /**
     * Slack's own identifier for the workspace.
     *
     * @param ClaudeTagSlackWorkspaceIdentifiers|ClaudeTagSlackWorkspaceIdentifiersShape $slack
     */
    public function withSlack(
        ClaudeTagSlackWorkspaceIdentifiers|array $slack
    ): self {
        $self = clone $this;
        $self['slack'] = $slack;

        return $self;
    }

    /**
     * For each setting, the settings level its value in `settings` comes from.
     *
     * @param ClaudeTagSettingSources|ClaudeTagSettingSourcesShape $sources
     */
    public function withSources(ClaudeTagSettingSources|array $sources): self
    {
        $self = clone $this;
        $self['sources'] = $sources;

        return $self;
    }

    /**
     * @param 'slack_workspace' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Time Claude Tag's record of the workspace last changed. It moves on every change to a setting, and can also move when something no response holds changes, so a later value says to read the workspace again, not that a setting changed. Attaching or detaching a Bundle does not by itself move it.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
