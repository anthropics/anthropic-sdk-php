<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaSkill\Type;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A skill that was loaded in a container (response model).
 *
 * @phpstan-type BetaSkillShape = array{
 *   skill_id: string, type: value-of<Type>, version: string
 * }
 */
final class BetaSkill implements BaseModel
{
    /** @use SdkModel<BetaSkillShape> */
    use SdkModel;

    /**
     * Skill ID.
     */
    #[Api]
    public string $skill_id;

    /**
     * Type of skill - either 'anthropic' (built-in) or 'custom' (user-defined).
     *
     * @var value-of<Type> $type
     */
    #[Api(enum: Type::class)]
    public string $type;

    /**
     * Skill version or 'latest' for most recent version.
     */
    #[Api]
    public string $version;

    /**
     * `new BetaSkill()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaSkill::with(skill_id: ..., type: ..., version: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaSkill)->withSkillID(...)->withType(...)->withVersion(...)
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
        string $skill_id,
        Type|string $type,
        string $version
    ): self {
        $obj = new self;

        $obj['skill_id'] = $skill_id;
        $obj['type'] = $type;
        $obj['version'] = $version;

        return $obj;
    }

    /**
     * Skill ID.
     */
    public function withSkillID(string $skillID): self
    {
        $obj = clone $this;
        $obj['skill_id'] = $skillID;

        return $obj;
    }

    /**
     * Type of skill - either 'anthropic' (built-in) or 'custom' (user-defined).
     *
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $obj = clone $this;
        $obj['type'] = $type;

        return $obj;
    }

    /**
     * Skill version or 'latest' for most recent version.
     */
    public function withVersion(string $version): self
    {
        $obj = clone $this;
        $obj['version'] = $version;

        return $obj;
    }
}
