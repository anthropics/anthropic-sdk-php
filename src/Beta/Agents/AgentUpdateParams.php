<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\AgentUpdateParams\Model;
use Anthropic\Beta\Agents\AgentUpdateParams\Tool;
use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\MapOf;

/**
 * Update Agent.
 *
 * @see Anthropic\Services\Beta\AgentsService::update()
 *
 * @phpstan-import-type ModelVariants from \Anthropic\Beta\Agents\AgentUpdateParams\Model
 * @phpstan-import-type BetaManagedAgentsSkillParamsVariants from \Anthropic\Beta\Agents\BetaManagedAgentsSkillParams
 * @phpstan-import-type ToolVariants from \Anthropic\Beta\Agents\AgentUpdateParams\Tool
 * @phpstan-import-type BetaManagedAgentsURLMCPServerParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsURLMCPServerParams
 * @phpstan-import-type ModelShape from \Anthropic\Beta\Agents\AgentUpdateParams\Model
 * @phpstan-import-type BetaManagedAgentsSkillParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsSkillParams
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Agents\AgentUpdateParams\Tool
 *
 * @phpstan-type AgentUpdateParamsShape = array{
 *   version: int,
 *   description?: string|null,
 *   mcpServers?: list<BetaManagedAgentsURLMCPServerParams|BetaManagedAgentsURLMCPServerParamsShape>|null,
 *   metadata?: array<string,string|null>|null,
 *   model?: ModelShape|null,
 *   name?: string|null,
 *   skills?: list<BetaManagedAgentsSkillParamsShape>|null,
 *   system?: string|null,
 *   tools?: list<ToolShape>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class AgentUpdateParams implements BaseModel
{
    /** @use SdkModel<AgentUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The agent's current version, used to prevent concurrent overwrites. Obtain this value from a create or retrieve response. The request fails if this does not match the server's current version.
     */
    #[Required]
    public int $version;

    /**
     * Description. Up to 2048 characters. Omit to preserve; send empty string or null to clear.
     */
    #[Optional(nullable: true)]
    public ?string $description;

    /**
     * MCP servers. Full replacement. Omit to preserve; send empty array or null to clear. Names must be unique. Maximum 20.
     *
     * @var list<BetaManagedAgentsURLMCPServerParams>|null $mcpServers
     */
    #[Optional(
        'mcp_servers',
        list: BetaManagedAgentsURLMCPServerParams::class,
        nullable: true,
    )]
    public ?array $mcpServers;

    /**
     * Metadata patch. Set a key to a string to upsert it, or to null to delete it. Omit the field to preserve. The stored bag is limited to 16 keys (up to 64 chars each) with values up to 512 chars.
     *
     * @var array<string,string|null>|null $metadata
     */
    #[Optional(type: new MapOf('string', nullable: true), nullable: true)]
    public ?array $metadata;

    /**
     * Model identifier. Accepts the [model string](https://platform.claude.com/docs/en/about-claude/models/overview#latest-models-comparison), e.g. `claude-opus-4-6`, or a `model_config` object for additional configuration control. Omit to preserve. Cannot be cleared.
     *
     * @var ModelVariants|null $model
     */
    #[Optional(union: Model::class)]
    public BetaManagedAgentsModelConfigParams|string|null $model;

    /**
     * Human-readable name. 1-256 characters. Omit to preserve. Cannot be cleared.
     */
    #[Optional]
    public ?string $name;

    /**
     * Skills. Full replacement. Omit to preserve; send empty array or null to clear. Maximum 20.
     *
     * @var list<BetaManagedAgentsSkillParamsVariants>|null $skills
     */
    #[Optional(list: BetaManagedAgentsSkillParams::class, nullable: true)]
    public ?array $skills;

    /**
     * System prompt. Up to 100,000 characters. Omit to preserve; send empty string or null to clear.
     */
    #[Optional(nullable: true)]
    public ?string $system;

    /**
     * Tool configurations available to the agent. Full replacement. Omit to preserve; send empty array or null to clear. Maximum of 128 tools across all toolsets allowed.
     *
     * @var list<ToolVariants>|null $tools
     */
    #[Optional(list: Tool::class, nullable: true)]
    public ?array $tools;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new AgentUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AgentUpdateParams::with(version: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AgentUpdateParams)->withVersion(...)
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
     * @param list<BetaManagedAgentsURLMCPServerParams|BetaManagedAgentsURLMCPServerParamsShape>|null $mcpServers
     * @param array<string,string|null>|null $metadata
     * @param ModelShape|null $model
     * @param list<BetaManagedAgentsSkillParamsShape>|null $skills
     * @param list<ToolShape>|null $tools
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        int $version,
        ?string $description = null,
        ?array $mcpServers = null,
        ?array $metadata = null,
        BetaManagedAgentsModel|BetaManagedAgentsModelConfigParams|array|string|null $model = null,
        ?string $name = null,
        ?array $skills = null,
        ?string $system = null,
        ?array $tools = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['version'] = $version;

        null !== $description && $self['description'] = $description;
        null !== $mcpServers && $self['mcpServers'] = $mcpServers;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $model && $self['model'] = $model;
        null !== $name && $self['name'] = $name;
        null !== $skills && $self['skills'] = $skills;
        null !== $system && $self['system'] = $system;
        null !== $tools && $self['tools'] = $tools;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * The agent's current version, used to prevent concurrent overwrites. Obtain this value from a create or retrieve response. The request fails if this does not match the server's current version.
     */
    public function withVersion(int $version): self
    {
        $self = clone $this;
        $self['version'] = $version;

        return $self;
    }

    /**
     * Description. Up to 2048 characters. Omit to preserve; send empty string or null to clear.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * MCP servers. Full replacement. Omit to preserve; send empty array or null to clear. Names must be unique. Maximum 20.
     *
     * @param list<BetaManagedAgentsURLMCPServerParams|BetaManagedAgentsURLMCPServerParamsShape>|null $mcpServers
     */
    public function withMCPServers(?array $mcpServers): self
    {
        $self = clone $this;
        $self['mcpServers'] = $mcpServers;

        return $self;
    }

    /**
     * Metadata patch. Set a key to a string to upsert it, or to null to delete it. Omit the field to preserve. The stored bag is limited to 16 keys (up to 64 chars each) with values up to 512 chars.
     *
     * @param array<string,string|null>|null $metadata
     */
    public function withMetadata(?array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Model identifier. Accepts the [model string](https://platform.claude.com/docs/en/about-claude/models/overview#latest-models-comparison), e.g. `claude-opus-4-6`, or a `model_config` object for additional configuration control. Omit to preserve. Cannot be cleared.
     *
     * @param ModelShape $model
     */
    public function withModel(
        BetaManagedAgentsModel|BetaManagedAgentsModelConfigParams|array|string $model,
    ): self {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    /**
     * Human-readable name. 1-256 characters. Omit to preserve. Cannot be cleared.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Skills. Full replacement. Omit to preserve; send empty array or null to clear. Maximum 20.
     *
     * @param list<BetaManagedAgentsSkillParamsShape>|null $skills
     */
    public function withSkills(?array $skills): self
    {
        $self = clone $this;
        $self['skills'] = $skills;

        return $self;
    }

    /**
     * System prompt. Up to 100,000 characters. Omit to preserve; send empty string or null to clear.
     */
    public function withSystem(?string $system): self
    {
        $self = clone $this;
        $self['system'] = $system;

        return $self;
    }

    /**
     * Tool configurations available to the agent. Full replacement. Omit to preserve; send empty array or null to clear. Maximum of 128 tools across all toolsets allowed.
     *
     * @param list<ToolShape>|null $tools
     */
    public function withTools(?array $tools): self
    {
        $self = clone $this;
        $self['tools'] = $tools;

        return $self;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
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
