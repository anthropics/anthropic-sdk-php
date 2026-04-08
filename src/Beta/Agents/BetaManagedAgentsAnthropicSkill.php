<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsAnthropicSkill\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A resolved Anthropic-managed skill.
 *
 * @phpstan-type BetaManagedAgentsAnthropicSkillShape = array{
 *   skillID: string, type: Type|value-of<Type>, version: string
 * }
 */
final class BetaManagedAgentsAnthropicSkill implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAnthropicSkillShape> */
    use SdkModel;

    #[Required('skill_id')]
    public string $skillID;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    #[Required]
    public string $version;

    /**
     * `new BetaManagedAgentsAnthropicSkill()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAnthropicSkill::with(skillID: ..., type: ..., version: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAnthropicSkill)
     *   ->withSkillID(...)
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
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $skillID,
        Type|string $type,
        string $version
    ): self {
        $self = new self;

        $self['skillID'] = $skillID;
        $self['type'] = $type;
        $self['version'] = $version;

        return $self;
    }

    public function withSkillID(string $skillID): self
    {
        $self = clone $this;
        $self['skillID'] = $skillID;

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

    public function withVersion(string $version): self
    {
        $self = clone $this;
        $self['version'] = $version;

        return $self;
    }
}
