<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A user-created custom skill.
 *
 * @phpstan-type BetaManagedAgentsCustomSkillParamsShape = array{
 *   skillID: string, type: 'custom', version?: string|null
 * }
 */
final class BetaManagedAgentsCustomSkillParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsCustomSkillParamsShape> */
    use SdkModel;

    /** @var 'custom' $type */
    #[Required(type: new ConstantOf('custom'))]
    public string $type = 'custom';

    /**
     * Tagged ID of the custom skill (e.g., "skill_01XJ5...").
     */
    #[Required('skill_id')]
    public string $skillID;

    /**
     * Version to pin. Defaults to latest if omitted.
     */
    #[Optional(nullable: true)]
    public ?string $version;

    /**
     * `new BetaManagedAgentsCustomSkillParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsCustomSkillParams::with(skillID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsCustomSkillParams())->withSkillID(...)
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
     * Tagged ID of the custom skill (e.g., "skill_01XJ5...").
     */
    public function withSkillID(string $skillID): self
    {
        $self = clone $this;
        $self['skillID'] = $skillID;

        return $self;
    }

    /**
     * @param 'custom' $type
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
