<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Threads;

use Anthropic\Beta\Agents\BetaManagedAgentsMCPServerURLDefinition;
use Anthropic\Beta\Agents\BetaManagedAgentsModelConfig;
use Anthropic\Beta\Sessions\Threads\ManagedAgentsInlineAgent\Skill;
use Anthropic\Beta\Sessions\Threads\ManagedAgentsInlineAgent\Tool;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * An agent that has no Agent resource, and so no `id` or `version`. It is defined inline, in a workflow run's plan or when a session thread is spawned, and is not saved.
 *
 * @phpstan-import-type BetaManagedAgentsMCPServerURLDefinitionShape from \Anthropic\Beta\Agents\BetaManagedAgentsMCPServerURLDefinition
 * @phpstan-import-type BetaManagedAgentsModelConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsModelConfig
 * @phpstan-import-type SkillShape from \Anthropic\Beta\Sessions\Threads\ManagedAgentsInlineAgent\Skill
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Sessions\Threads\ManagedAgentsInlineAgent\Tool
 * @phpstan-import-type SkillVariants from \Anthropic\Beta\Sessions\Threads\ManagedAgentsInlineAgent\Skill
 * @phpstan-import-type ToolVariants from \Anthropic\Beta\Sessions\Threads\ManagedAgentsInlineAgent\Tool
 *
 * @phpstan-type ManagedAgentsInlineAgentShape = array{
 *   description: string|null,
 *   mcpServers: list<BetaManagedAgentsMCPServerURLDefinition|BetaManagedAgentsMCPServerURLDefinitionShape>,
 *   model: BetaManagedAgentsModelConfig|BetaManagedAgentsModelConfigShape,
 *   name: string,
 *   skills: list<SkillShape>,
 *   system: string|null,
 *   tools: list<ToolShape>,
 *   type: 'inline',
 * }
 */
final class ManagedAgentsInlineAgent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsInlineAgentShape> */
    use SdkModel;

    /** @var 'inline' $type */
    #[Required(type: new ConstantOf('inline'))]
    public string $type = 'inline';

    #[Required]
    public ?string $description;

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

    /**
     * The name that the agent's definition gave, or one that the server assigned.
     */
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

    /**
     * `new ManagedAgentsInlineAgent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsInlineAgent::with(
     *   description: ...,
     *   mcpServers: ...,
     *   model: ...,
     *   name: ...,
     *   skills: ...,
     *   system: ...,
     *   tools: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsInlineAgent())
     *   ->withDescription(...)
     *   ->withMCPServers(...)
     *   ->withModel(...)
     *   ->withName(...)
     *   ->withSkills(...)
     *   ->withSystem(...)
     *   ->withTools(...)
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
     * @param list<BetaManagedAgentsMCPServerURLDefinition|BetaManagedAgentsMCPServerURLDefinitionShape> $mcpServers
     * @param BetaManagedAgentsModelConfig|BetaManagedAgentsModelConfigShape $model
     * @param list<SkillShape> $skills
     * @param list<ToolShape> $tools
     */
    public static function with(
        ?string $description,
        array $mcpServers,
        BetaManagedAgentsModelConfig|array $model,
        string $name,
        array $skills,
        ?string $system,
        array $tools,
    ): self {
        $self = new self;

        $self['description'] = $description;
        $self['mcpServers'] = $mcpServers;
        $self['model'] = $model;
        $self['name'] = $name;
        $self['skills'] = $skills;
        $self['system'] = $system;
        $self['tools'] = $tools;

        return $self;
    }

    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

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

    /**
     * The name that the agent's definition gave, or one that the server assigned.
     */
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
     * @param 'inline' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
