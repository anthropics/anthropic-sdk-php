<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * An Anthropic-managed skill.
 *
 * @phpstan-type BetaManagedAgentsAnthropicSkillParamsShape = array{
 *   skillID: string, type: 'anthropic', version?: string|null
 * }
 */
final class BetaManagedAgentsAnthropicSkillParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAnthropicSkillParamsShape> */
    use SdkModel;

    /** @var 'anthropic' $type */
    #[Required(type: new ConstantOf('anthropic'))]
    public string $type = 'anthropic';

    /**
     * Identifier of the Anthropic skill (e.g., "xlsx").
     */
    #[Required('skill_id')]
    public string $skillID;

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
     * BetaManagedAgentsAnthropicSkillParams::with(skillID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAnthropicSkillParams())->withSkillID(...)
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
    public static function with(string $skillID, ?string $version = null): self
    {
        $self = new self;

        $self['skillID'] = $skillID;

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
     * @param 'anthropic' $type
     */
    public function withType(string $type): self
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
