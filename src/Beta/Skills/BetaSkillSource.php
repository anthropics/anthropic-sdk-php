<?php

declare(strict_types=1);

namespace Anthropic\Beta\Skills;

use Anthropic\Beta\Skills\BetaSkillSource\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaSkillSourceShape = array{type: Type|value-of<Type>}
 */
final class BetaSkillSource implements BaseModel
{
    /** @use SdkModel<BetaSkillSourceShape> */
    use SdkModel;

    /**
     * Where the Skill comes from.
     *
     * Possible values:
     * * `"custom"`: authored by the platform user; private to their workspace
     * * `"anthropic"`: published by Anthropic; shared and read-only
     * * `"anthropic_example"`: Anthropic-published sample Skill
     * * `"plugin"`: resolved from an installed plugin
     *
     * @var value-of<Type> $type
     */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaSkillSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaSkillSource::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaSkillSource)->withType(...)
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
    public static function with(Type|string $type): self
    {
        $self = new self;

        $self['type'] = $type;

        return $self;
    }

    /**
     * Where the Skill comes from.
     *
     * Possible values:
     * * `"custom"`: authored by the platform user; private to their workspace
     * * `"anthropic"`: published by Anthropic; shared and read-only
     * * `"anthropic_example"`: Anthropic-published sample Skill
     * * `"plugin"`: resolved from an installed plugin
     *
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
