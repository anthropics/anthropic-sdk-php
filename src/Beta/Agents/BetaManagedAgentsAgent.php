<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsAgent\Skill;
use Anthropic\Beta\Agents\BetaManagedAgentsAgent\Tool;
use Anthropic\Beta\Agents\BetaManagedAgentsAgent\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A Managed Agents `agent`.
 *
 * @phpstan-import-type SkillVariants from \Anthropic\Beta\Agents\BetaManagedAgentsAgent\Skill
 * @phpstan-import-type ToolVariants from \Anthropic\Beta\Agents\BetaManagedAgentsAgent\Tool
 * @phpstan-import-type BetaManagedAgentsMCPServerURLDefinitionShape from \Anthropic\Beta\Agents\BetaManagedAgentsMCPServerURLDefinition
 * @phpstan-import-type BetaManagedAgentsModelConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsModelConfig
 * @phpstan-import-type SkillShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgent\Skill
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgent\Tool
 *
 * @phpstan-type BetaManagedAgentsAgentShape = array{
 *   id: string,
 *   archivedAt: \DateTimeInterface|null,
 *   createdAt: \DateTimeInterface,
 *   description: string|null,
 *   mcpServers: list<BetaManagedAgentsMCPServerURLDefinition|BetaManagedAgentsMCPServerURLDefinitionShape>,
 *   metadata: array<string,string>,
 *   model: BetaManagedAgentsModelConfig|BetaManagedAgentsModelConfigShape,
 *   name: string,
 *   skills: list<SkillShape>,
 *   system: string|null,
 *   tools: list<ToolShape>,
 *   type: Type|value-of<Type>,
 *   updatedAt: \DateTimeInterface,
 *   version: int,
 * }
 */
final class BetaManagedAgentsAgent implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAgentShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('archived_at')]
    public ?\DateTimeInterface $archivedAt;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    #[Required]
    public ?string $description;

    /** @var list<BetaManagedAgentsMCPServerURLDefinition> $mcpServers */
    #[Required(
        'mcp_servers',
        list: BetaManagedAgentsMCPServerURLDefinition::class
    )]
    public array $mcpServers;

    /** @var array<string,string> $metadata */
    #[Required(map: 'string')]
    public array $metadata;

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

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * The agent's current version. Starts at 1 and increments when the agent is modified.
     */
    #[Required]
    public int $version;

    /**
     * `new BetaManagedAgentsAgent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAgent::with(
     *   id: ...,
     *   archivedAt: ...,
     *   createdAt: ...,
     *   description: ...,
     *   mcpServers: ...,
     *   metadata: ...,
     *   model: ...,
     *   name: ...,
     *   skills: ...,
     *   system: ...,
     *   tools: ...,
     *   type: ...,
     *   updatedAt: ...,
     *   version: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAgent)
     *   ->withID(...)
     *   ->withArchivedAt(...)
     *   ->withCreatedAt(...)
     *   ->withDescription(...)
     *   ->withMCPServers(...)
     *   ->withMetadata(...)
     *   ->withModel(...)
     *   ->withName(...)
     *   ->withSkills(...)
     *   ->withSystem(...)
     *   ->withTools(...)
     *   ->withType(...)
     *   ->withUpdatedAt(...)
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
     * @param array<string,string> $metadata
     * @param BetaManagedAgentsModelConfig|BetaManagedAgentsModelConfigShape $model
     * @param list<SkillShape> $skills
     * @param list<ToolShape> $tools
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $id,
        ?\DateTimeInterface $archivedAt,
        \DateTimeInterface $createdAt,
        ?string $description,
        array $mcpServers,
        array $metadata,
        BetaManagedAgentsModelConfig|array $model,
        string $name,
        array $skills,
        ?string $system,
        array $tools,
        Type|string $type,
        \DateTimeInterface $updatedAt,
        int $version,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['archivedAt'] = $archivedAt;
        $self['createdAt'] = $createdAt;
        $self['description'] = $description;
        $self['mcpServers'] = $mcpServers;
        $self['metadata'] = $metadata;
        $self['model'] = $model;
        $self['name'] = $name;
        $self['skills'] = $skills;
        $self['system'] = $system;
        $self['tools'] = $tools;
        $self['type'] = $type;
        $self['updatedAt'] = $updatedAt;
        $self['version'] = $version;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withArchivedAt(?\DateTimeInterface $archivedAt): self
    {
        $self = clone $this;
        $self['archivedAt'] = $archivedAt;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

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
     * @param array<string,string> $metadata
     */
    public function withMetadata(array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

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

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * The agent's current version. Starts at 1 and increments when the agent is modified.
     */
    public function withVersion(int $version): self
    {
        $self = clone $this;
        $self['version'] = $version;

        return $self;
    }
}
