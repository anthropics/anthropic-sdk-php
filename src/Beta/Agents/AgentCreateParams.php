<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\AgentCreateParams\Model;
use Anthropic\Beta\Agents\AgentCreateParams\Tool;
use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Create Agent.
 *
 * @see Anthropic\Services\Beta\AgentsService::create()
 *
 * @phpstan-import-type ModelVariants from \Anthropic\Beta\Agents\AgentCreateParams\Model
 * @phpstan-import-type BetaManagedAgentsSkillParamsVariants from \Anthropic\Beta\Agents\BetaManagedAgentsSkillParams
 * @phpstan-import-type ToolVariants from \Anthropic\Beta\Agents\AgentCreateParams\Tool
 * @phpstan-import-type ModelShape from \Anthropic\Beta\Agents\AgentCreateParams\Model
 * @phpstan-import-type BetaManagedAgentsURLMCPServerParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsURLMCPServerParams
 * @phpstan-import-type BetaManagedAgentsSkillParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsSkillParams
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Agents\AgentCreateParams\Tool
 *
 * @phpstan-type AgentCreateParamsShape = array{
 *   model: ModelShape,
 *   name: string,
 *   description?: string|null,
 *   mcpServers?: list<BetaManagedAgentsURLMCPServerParams|BetaManagedAgentsURLMCPServerParamsShape>|null,
 *   metadata?: array<string,string>|null,
 *   skills?: list<BetaManagedAgentsSkillParamsShape>|null,
 *   system?: string|null,
 *   tools?: list<ToolShape>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class AgentCreateParams implements BaseModel
{
    /** @use SdkModel<AgentCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Model identifier. Accepts the [model string](https://platform.claude.com/docs/en/about-claude/models/overview#latest-models-comparison), e.g. `claude-opus-4-6`, or a `model_config` object for additional configuration control.
     *
     * @var ModelVariants $model
     */
    #[Required(union: Model::class)]
    public BetaManagedAgentsModelConfigParams|string $model;

    /**
     * Human-readable name for the agent. 1-256 characters.
     */
    #[Required]
    public string $name;

    /**
     * Description of what the agent does. Up to 2048 characters.
     */
    #[Optional(nullable: true)]
    public ?string $description;

    /**
     * MCP servers this agent connects to. Maximum 20. Names must be unique within the array.
     *
     * @var list<BetaManagedAgentsURLMCPServerParams>|null $mcpServers
     */
    #[Optional('mcp_servers', list: BetaManagedAgentsURLMCPServerParams::class)]
    public ?array $mcpServers;

    /**
     * Arbitrary key-value metadata. Maximum 16 pairs, keys up to 64 chars, values up to 512 chars.
     *
     * @var array<string,string>|null $metadata
     */
    #[Optional(map: 'string')]
    public ?array $metadata;

    /**
     * Skills available to the agent. Maximum 20.
     *
     * @var list<BetaManagedAgentsSkillParamsVariants>|null $skills
     */
    #[Optional(list: BetaManagedAgentsSkillParams::class)]
    public ?array $skills;

    /**
     * System prompt for the agent. Up to 100,000 characters.
     */
    #[Optional(nullable: true)]
    public ?string $system;

    /**
     * Tool configurations available to the agent. Maximum of 128 tools across all toolsets allowed.
     *
     * @var list<ToolVariants>|null $tools
     */
    #[Optional(list: Tool::class)]
    public ?array $tools;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new AgentCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AgentCreateParams::with(model: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AgentCreateParams)->withModel(...)->withName(...)
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
     * @param ModelShape $model
     * @param list<BetaManagedAgentsURLMCPServerParams|BetaManagedAgentsURLMCPServerParamsShape>|null $mcpServers
     * @param array<string,string>|null $metadata
     * @param list<BetaManagedAgentsSkillParamsShape>|null $skills
     * @param list<ToolShape>|null $tools
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        BetaManagedAgentsModel|BetaManagedAgentsModelConfigParams|array|string $model,
        string $name,
        ?string $description = null,
        ?array $mcpServers = null,
        ?array $metadata = null,
        ?array $skills = null,
        ?string $system = null,
        ?array $tools = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['model'] = $model;
        $self['name'] = $name;

        null !== $description && $self['description'] = $description;
        null !== $mcpServers && $self['mcpServers'] = $mcpServers;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $skills && $self['skills'] = $skills;
        null !== $system && $self['system'] = $system;
        null !== $tools && $self['tools'] = $tools;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Model identifier. Accepts the [model string](https://platform.claude.com/docs/en/about-claude/models/overview#latest-models-comparison), e.g. `claude-opus-4-6`, or a `model_config` object for additional configuration control.
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
     * Human-readable name for the agent. 1-256 characters.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Description of what the agent does. Up to 2048 characters.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * MCP servers this agent connects to. Maximum 20. Names must be unique within the array.
     *
     * @param list<BetaManagedAgentsURLMCPServerParams|BetaManagedAgentsURLMCPServerParamsShape> $mcpServers
     */
    public function withMCPServers(array $mcpServers): self
    {
        $self = clone $this;
        $self['mcpServers'] = $mcpServers;

        return $self;
    }

    /**
     * Arbitrary key-value metadata. Maximum 16 pairs, keys up to 64 chars, values up to 512 chars.
     *
     * @param array<string,string> $metadata
     */
    public function withMetadata(array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Skills available to the agent. Maximum 20.
     *
     * @param list<BetaManagedAgentsSkillParamsShape> $skills
     */
    public function withSkills(array $skills): self
    {
        $self = clone $this;
        $self['skills'] = $skills;

        return $self;
    }

    /**
     * System prompt for the agent. Up to 100,000 characters.
     */
    public function withSystem(?string $system): self
    {
        $self = clone $this;
        $self['system'] = $system;

        return $self;
    }

    /**
     * Tool configurations available to the agent. Maximum of 128 tools across all toolsets allowed.
     *
     * @param list<ToolShape> $tools
     */
    public function withTools(array $tools): self
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
