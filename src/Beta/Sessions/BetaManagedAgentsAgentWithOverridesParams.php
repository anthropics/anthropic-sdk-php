<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Agents\BetaManagedAgentsModel;
use Anthropic\Beta\Agents\BetaManagedAgentsModelConfigParams;
use Anthropic\Beta\Agents\BetaManagedAgentsSkillParams;
use Anthropic\Beta\Agents\BetaManagedAgentsURLMCPServerParams;
use Anthropic\Beta\Sessions\BetaManagedAgentsAgentWithOverridesParams\Model;
use Anthropic\Beta\Sessions\BetaManagedAgentsAgentWithOverridesParams\Tool;
use Anthropic\Beta\Sessions\BetaManagedAgentsAgentWithOverridesParams\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Reference to an `agent` plus optional configuration overrides. Each provided field replaces the agent's value for the caller's use; the agent resource is unchanged.
 *
 * @phpstan-import-type ModelVariants from \Anthropic\Beta\Sessions\BetaManagedAgentsAgentWithOverridesParams\Model
 * @phpstan-import-type BetaManagedAgentsSkillParamsVariants from \Anthropic\Beta\Agents\BetaManagedAgentsSkillParams
 * @phpstan-import-type ToolVariants from \Anthropic\Beta\Sessions\BetaManagedAgentsAgentWithOverridesParams\Tool
 * @phpstan-import-type BetaManagedAgentsURLMCPServerParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsURLMCPServerParams
 * @phpstan-import-type ModelShape from \Anthropic\Beta\Sessions\BetaManagedAgentsAgentWithOverridesParams\Model
 * @phpstan-import-type BetaManagedAgentsSkillParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsSkillParams
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Sessions\BetaManagedAgentsAgentWithOverridesParams\Tool
 *
 * @phpstan-type BetaManagedAgentsAgentWithOverridesParamsShape = array{
 *   id: string,
 *   type: Type|value-of<Type>,
 *   mcpServers?: list<BetaManagedAgentsURLMCPServerParams|BetaManagedAgentsURLMCPServerParamsShape>|null,
 *   model?: ModelShape|null,
 *   skills?: list<BetaManagedAgentsSkillParamsShape>|null,
 *   system?: string|null,
 *   tools?: list<ToolShape>|null,
 *   version?: int|null,
 * }
 */
final class BetaManagedAgentsAgentWithOverridesParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAgentWithOverridesParamsShape> */
    use SdkModel;

    /**
     * The `agent` ID.
     */
    #[Required]
    public string $id;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Replacement MCP server list. Full replacement: the provided array becomes the MCP servers. Send an empty array to clear; omit to preserve the agent's servers.
     *
     * @var list<BetaManagedAgentsURLMCPServerParams>|null $mcpServers
     */
    #[Optional('mcp_servers', list: BetaManagedAgentsURLMCPServerParams::class)]
    public ?array $mcpServers;

    /**
     * Replacement model. Accepts the model string, e.g. `claude-opus-4-6`, or a `model_config` object. Omit to use the agent's model.
     *
     * @var ModelVariants|null $model
     */
    #[Optional(union: Model::class)]
    public BetaManagedAgentsModelConfigParams|string|null $model;

    /**
     * Replacement skill list. Full replacement: the provided array becomes the skills. Send an empty array to clear; omit to preserve the agent's skills.
     *
     * @var list<BetaManagedAgentsSkillParamsVariants>|null $skills
     */
    #[Optional(list: BetaManagedAgentsSkillParams::class)]
    public ?array $skills;

    /**
     * Replacement system prompt. Up to 100,000 characters. Set to null to clear the agent's system prompt; omit to preserve it.
     */
    #[Optional(nullable: true)]
    public ?string $system;

    /**
     * Replacement tool list. Full replacement: the provided array becomes the tool configuration. Send an empty array to clear; omit to preserve the agent's tools.
     *
     * @var list<ToolVariants>|null $tools
     */
    #[Optional(list: Tool::class)]
    public ?array $tools;

    /**
     * The specific `agent` version to use. Omit to use the latest version.
     */
    #[Optional]
    public ?int $version;

    /**
     * `new BetaManagedAgentsAgentWithOverridesParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAgentWithOverridesParams::with(id: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAgentWithOverridesParams)->withID(...)->withType(...)
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
     * @param Type|value-of<Type> $type
     * @param list<BetaManagedAgentsURLMCPServerParams|BetaManagedAgentsURLMCPServerParamsShape>|null $mcpServers
     * @param ModelShape|null $model
     * @param list<BetaManagedAgentsSkillParamsShape>|null $skills
     * @param list<ToolShape>|null $tools
     */
    public static function with(
        string $id,
        Type|string $type,
        ?array $mcpServers = null,
        BetaManagedAgentsModel|BetaManagedAgentsModelConfigParams|array|string|null $model = null,
        ?array $skills = null,
        ?string $system = null,
        ?array $tools = null,
        ?int $version = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['type'] = $type;

        null !== $mcpServers && $self['mcpServers'] = $mcpServers;
        null !== $model && $self['model'] = $model;
        null !== $skills && $self['skills'] = $skills;
        null !== $system && $self['system'] = $system;
        null !== $tools && $self['tools'] = $tools;
        null !== $version && $self['version'] = $version;

        return $self;
    }

    /**
     * The `agent` ID.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Replacement MCP server list. Full replacement: the provided array becomes the MCP servers. Send an empty array to clear; omit to preserve the agent's servers.
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
     * Replacement model. Accepts the model string, e.g. `claude-opus-4-6`, or a `model_config` object. Omit to use the agent's model.
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
     * Replacement skill list. Full replacement: the provided array becomes the skills. Send an empty array to clear; omit to preserve the agent's skills.
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
     * Replacement system prompt. Up to 100,000 characters. Set to null to clear the agent's system prompt; omit to preserve it.
     */
    public function withSystem(?string $system): self
    {
        $self = clone $this;
        $self['system'] = $system;

        return $self;
    }

    /**
     * Replacement tool list. Full replacement: the provided array becomes the tool configuration. Send an empty array to clear; omit to preserve the agent's tools.
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
     * The specific `agent` version to use. Omit to use the latest version.
     */
    public function withVersion(int $version): self
    {
        $self = clone $this;
        $self['version'] = $version;

        return $self;
    }
}
