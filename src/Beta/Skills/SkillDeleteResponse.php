<?php

declare(strict_types=1);

namespace Anthropic\Beta\Skills;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type SkillDeleteResponseShape = array{id: string, type: string}
 */
final class SkillDeleteResponse implements BaseModel
{
    /** @use SdkModel<SkillDeleteResponseShape> */
    use SdkModel;

    /**
     * Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     */
    #[Required]
    public string $id;

    /**
     * Deleted object type.
     *
     * For Skills, this is always `"skill_deleted"`.
     */
    #[Required]
    public string $type;

    /**
     * `new SkillDeleteResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SkillDeleteResponse::with(id: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SkillDeleteResponse)->withID(...)->withType(...)
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
    public static function with(
        string $id,
        string $type = 'skill_deleted'
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Deleted object type.
     *
     * For Skills, this is always `"skill_deleted"`.
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
