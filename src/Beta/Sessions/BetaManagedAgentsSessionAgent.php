<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Agents\BetaManagedAgentsMCPServerURLDefinition;
use Anthropic\Beta\Agents\BetaManagedAgentsModelConfig;
use Anthropic\Beta\Sessions\BetaManagedAgentsSessionAgent\Skill;
use Anthropic\Beta\Sessions\BetaManagedAgentsSessionAgent\Tool;
use Anthropic\Beta\Sessions\BetaManagedAgentsSessionAgent\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Resolved `agent` definition for a `session`. Snapshot of the `agent` at `session` creation time.
 *
 * @phpstan-import-type SkillVariants from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionAgent\Skill
 * @phpstan-import-type ToolVariants from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionAgent\Tool
 * @phpstan-import-type BetaManagedAgentsMCPServerURLDefinitionShape from \Anthropic\Beta\Agents\BetaManagedAgentsMCPServerURLDefinition
 * @phpstan-import-type BetaManagedAgentsModelConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsModelConfig
 * @phpstan-import-type SkillShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionAgent\Skill
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionAgent\Tool
 *
 * @phpstan-type BetaManagedAgentsSessionAgentShape = array{
 *   id: string,
 *   description: string|null,
 *   mcpServers: list<BetaManagedAgentsMCPServerURLDefinition|BetaManagedAgentsMCPServerURLDefinitionShape>,
 *   model: BetaManagedAgentsModelConfig|BetaManagedAgentsModelConfigShape,
 *   name: string,
 *   skills: list<SkillShape>,
 *   system: string|null,
 *   tools: list<ToolShape>,
 *   type: Type|value-of<Type>,
 *   version: int,
 * }
 */
final class BetaManagedAgentsSessionAgent implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSessionAgentShape> */
    use SdkModel;

    #[Required]
    public string $id;

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

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    #[Required]
    public int $version;

    /**
     * `new BetaManagedAgentsSessionAgent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsSessionAgent::with(
     *   id: ...,
     *   description: ...,
     *   mcpServers: ...,
     *   model: ...,
     *   name: ...,
     *   skills: ...,
     *   system: ...,
     *   tools: ...,
     *   type: ...,
     *   version: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsSessionAgent)
     *   ->withID(...)
     *   ->withDescription(...)
     *   ->withMCPServers(...)
     *   ->withModel(...)
     *   ->withName(...)
     *   ->withSkills(...)
     *   ->withSystem(...)
     *   ->withTools(...)
     *   ->withType(...)
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
     * @param list<BetaManagedAgentsMCPServerURLDefinition|BetaManagedAgentsMCPServerURLDefinitionShape> $mcpServers
     * @param BetaManagedAgentsModelConfig|BetaManagedAgentsModelConfigShape $model
     * @param list<SkillShape> $skills
     * @param list<ToolShape> $tools
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $id,
        ?string $description,
        array $mcpServers,
        BetaManagedAgentsModelConfig|array $model,
        string $name,
        array $skills,
        ?string $system,
        array $tools,
        Type|string $type,
        int $version,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['description'] = $description;
        $self['mcpServers'] = $mcpServers;
        $self['model'] = $model;
        $self['name'] = $name;
        $self['skills'] = $skills;
        $self['system'] = $system;
        $self['tools'] = $tools;
        $self['type'] = $type;
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
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
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
