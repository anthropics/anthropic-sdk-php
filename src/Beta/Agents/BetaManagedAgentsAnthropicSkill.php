<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A resolved Anthropic-managed skill.
 *
 * @phpstan-type BetaManagedAgentsAnthropicSkillShape = array{
 *   skillID: string, type: 'anthropic', version: string
 * }
 */
final class BetaManagedAgentsAnthropicSkill implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAnthropicSkillShape> */
    use SdkModel;

    /** @var 'anthropic' $type */
    #[Required(type: new ConstantOf('anthropic'))]
    public string $type = 'anthropic';

    #[Required('skill_id')]
    public string $skillID;

    #[Required]
    public string $version;

    /**
     * `new BetaManagedAgentsAnthropicSkill()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAnthropicSkill::with(skillID: ..., version: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAnthropicSkill())->withSkillID(...)->withVersion(...)
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
     */
    public static function with(string $skillID, string $version): self
    {
        $self = new self;

        $self['skillID'] = $skillID;
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
     * @param 'anthropic' $type
     */
    public function withType(string $type): self
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
