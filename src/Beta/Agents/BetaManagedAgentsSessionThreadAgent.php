<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsSessionThreadAgent\Skill;
use Anthropic\Beta\Agents\BetaManagedAgentsSessionThreadAgent\Tool;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Resolved `agent` definition for a single `session_thread`. Snapshot of the agent at thread creation time. The multiagent roster is not repeated here; read it from `Session.agent`.
 *
 * @phpstan-import-type BetaManagedAgentsExecutionIdentityShape from \Anthropic\Beta\Agents\BetaManagedAgentsExecutionIdentity
 * @phpstan-import-type BetaManagedAgentsMCPServerURLDefinitionShape from \Anthropic\Beta\Agents\BetaManagedAgentsMCPServerURLDefinition
 * @phpstan-import-type BetaManagedAgentsModelConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsModelConfig
 * @phpstan-import-type SkillShape from \Anthropic\Beta\Agents\BetaManagedAgentsSessionThreadAgent\Skill
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Agents\BetaManagedAgentsSessionThreadAgent\Tool
 * @phpstan-import-type BetaManagedAgentsExecutionIdentityVariants from \Anthropic\Beta\Agents\BetaManagedAgentsExecutionIdentity
 * @phpstan-import-type SkillVariants from \Anthropic\Beta\Agents\BetaManagedAgentsSessionThreadAgent\Skill
 * @phpstan-import-type ToolVariants from \Anthropic\Beta\Agents\BetaManagedAgentsSessionThreadAgent\Tool
 *
 * @phpstan-type BetaManagedAgentsSessionThreadAgentShape = array{
 *   id: string,
 *   description: string|null,
 *   executionIdentity: BetaManagedAgentsExecutionIdentityShape,
 *   mcpServers: list<BetaManagedAgentsMCPServerURLDefinition|BetaManagedAgentsMCPServerURLDefinitionShape>,
 *   model: BetaManagedAgentsModelConfig|BetaManagedAgentsModelConfigShape,
 *   name: string,
 *   skills: list<SkillShape>,
 *   system: string|null,
 *   tools: list<ToolShape>,
 *   type: 'agent',
 *   version: int,
 * }
 */
final class BetaManagedAgentsSessionThreadAgent implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSessionThreadAgentShape> */
    use SdkModel;

    /** @var 'agent' $type */
    #[Required(type: new ConstantOf('agent'))]
    public string $type = 'agent';

    #[Required]
    public string $id;

    #[Required]
    public ?string $description;

    /**
     * Execution principal snapshotted from the agent at session creation. Always present; `{"type": "service_account"}` when runs carry no customer-named principal.
     *
     * @var BetaManagedAgentsExecutionIdentityVariants $executionIdentity
     */
    #[Required(
        'execution_identity',
        union: BetaManagedAgentsExecutionIdentity::class
    )]
    public BetaManagedAgentsAWSRoleExecutionIdentity|BetaManagedAgentsServiceAccountExecutionIdentity $executionIdentity;

    /** @var list<BetaManagedAgentsMCPServerURLDefinition> $mcpServers */
    #[Required(
        'mcp_servers',
        list: BetaManagedAgentsMCPServerURLDefinition::class
    )]
    public array $mcpServers;

    /**
     * Model identifier and configuration.
     */
    #[Required]
    public BetaManagedAgentsModelConfig $model;

    #[Required]
    public string $name;

    /** @var list<SkillVariants> $skills */
    #[Required(list: Skill::class)]
    public array $skills;

    #[Required]
    public ?string $system;

    /** @var list<ToolVariants> $tools */
    #[Required(list: Tool::class)]
    public array $tools;

    #[Required]
    public int $version;

    /**
     * `new BetaManagedAgentsSessionThreadAgent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsSessionThreadAgent::with(
     *   id: ...,
     *   description: ...,
     *   executionIdentity: ...,
     *   mcpServers: ...,
     *   model: ...,
     *   name: ...,
     *   skills: ...,
     *   system: ...,
     *   tools: ...,
     *   version: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsSessionThreadAgent())
     *   ->withID(...)
     *   ->withDescription(...)
     *   ->withExecutionIdentity(...)
     *   ->withMCPServers(...)
     *   ->withModel(...)
     *   ->withName(...)
     *   ->withSkills(...)
     *   ->withSystem(...)
     *   ->withTools(...)
     *   ->withVersion(...)
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
     * @param BetaManagedAgentsExecutionIdentityShape $executionIdentity
     * @param list<BetaManagedAgentsMCPServerURLDefinition|BetaManagedAgentsMCPServerURLDefinitionShape> $mcpServers
     * @param BetaManagedAgentsModelConfig|BetaManagedAgentsModelConfigShape $model
     * @param list<SkillShape> $skills
     * @param list<ToolShape> $tools
     */
    public static function with(
        string $id,
        ?string $description,
        BetaManagedAgentsAWSRoleExecutionIdentity|array|BetaManagedAgentsServiceAccountExecutionIdentity $executionIdentity,
        array $mcpServers,
        BetaManagedAgentsModelConfig|array $model,
        string $name,
        array $skills,
        ?string $system,
        array $tools,
        int $version,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['description'] = $description;
        $self['executionIdentity'] = $executionIdentity;
        $self['mcpServers'] = $mcpServers;
        $self['model'] = $model;
        $self['name'] = $name;
        $self['skills'] = $skills;
        $self['system'] = $system;
        $self['tools'] = $tools;
        $self['version'] = $version;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Execution principal snapshotted from the agent at session creation. Always present; `{"type": "service_account"}` when runs carry no customer-named principal.
     *
     * @param BetaManagedAgentsExecutionIdentityShape $executionIdentity
     */
    public function withExecutionIdentity(
        BetaManagedAgentsAWSRoleExecutionIdentity|array|BetaManagedAgentsServiceAccountExecutionIdentity $executionIdentity,
    ): self {
        $self = clone $this;
        $self['executionIdentity'] = $executionIdentity;

        return $self;
    }

    /**
     * @param list<BetaManagedAgentsMCPServerURLDefinition|BetaManagedAgentsMCPServerURLDefinitionShape> $mcpServers
     */
    public function withMCPServers(array $mcpServers): self
    {
        $self = clone $this;
        $self['mcpServers'] = $mcpServers;

        return $self;
    }

    /**
     * Model identifier and configuration.
     *
     * @param BetaManagedAgentsModelConfig|BetaManagedAgentsModelConfigShape $model
     */
    public function withModel(BetaManagedAgentsModelConfig|array $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param list<SkillShape> $skills
     */
    public function withSkills(array $skills): self
    {
        $self = clone $this;
        $self['skills'] = $skills;

        return $self;
    }

    public function withSystem(?string $system): self
    {
        $self = clone $this;
        $self['system'] = $system;

        return $self;
    }

    /**
     * @param list<ToolShape> $tools
     */
    public function withTools(array $tools): self
    {
        $self = clone $this;
        $self['tools'] = $tools;

        return $self;
    }

    /**
     * @param 'agent' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    public function withVersion(int $version): self
    {
        $self = clone $this;
        $self['version'] = $version;

        return $self;
    }
}
