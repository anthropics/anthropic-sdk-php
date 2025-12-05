<?php

declare(strict_types=1);

namespace Anthropic\Beta\Skills;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkResponse;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\Contracts\ResponseConverter;

/**
 * @phpstan-type SkillDeleteResponseShape = array{id: string, type: string}
 */
final class SkillDeleteResponse implements BaseModel, ResponseConverter
{
    /** @use SdkModel<SkillDeleteResponseShape> */
    use SdkModel;

    use SdkResponse;

    /**
     * Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     */
    #[Api]
    public string $id;

    /**
     * Deleted object type.
     *
     * For Skills, this is always `"skill_deleted"`.
     */
    #[Api]
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
        $obj = new self;

        $obj['id'] = $id;
        $obj['type'] = $type;

        return $obj;
    }

    /**
     * Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     */
    public function withID(string $id): self
    {
        $obj = clone $this;
        $obj['id'] = $id;

        return $obj;
    }

    /**
     * Deleted object type.
     *
     * For Skills, this is always `"skill_deleted"`.
     */
    public function withType(string $type): self
    {
        $obj = clone $this;
        $obj['type'] = $type;

        return $obj;
    }
}
