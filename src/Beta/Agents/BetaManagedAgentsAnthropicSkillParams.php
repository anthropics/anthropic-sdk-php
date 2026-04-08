<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsAnthropicSkillParams\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * An Anthropic-managed skill.
 *
 * @phpstan-type BetaManagedAgentsAnthropicSkillParamsShape = array{
 *   skillID: string, type: Type|value-of<Type>, version?: string|null
 * }
 */
final class BetaManagedAgentsAnthropicSkillParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAnthropicSkillParamsShape> */
    use SdkModel;

    /**
     * Identifier of the Anthropic skill (e.g., "xlsx").
     */
    #[Required('skill_id')]
    public string $skillID;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Version to pin. Defaults to latest if omitted.
     */
    #[Optional(nullable: true)]
    public ?string $version;

    /**
     * `new BetaManagedAgentsAnthropicSkillParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAnthropicSkillParams::with(skillID: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAnthropicSkillParams)->withSkillID(...)->withType(...)
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
        ?string $version = null
    ): self {
        $self = new self;

        $self['skillID'] = $skillID;
        $self['type'] = $type;

        null !== $version && $self['version'] = $version;

        return $self;
    }

    /**
     * Identifier of the Anthropic skill (e.g., "xlsx").
     */
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

    /**
     * Version to pin. Defaults to latest if omitted.
     */
    public function withVersion(?string $version): self
    {
        $self = clone $this;
        $self['version'] = $version;

        return $self;
    }
}
