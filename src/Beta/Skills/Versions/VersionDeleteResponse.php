<?php

declare(strict_types=1);

namespace Anthropic\Beta\Skills\Versions;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkResponse;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\Contracts\ResponseConverter;

/**
 * @phpstan-type VersionDeleteResponseShape = array{id: string, type: string}
 */
final class VersionDeleteResponse implements BaseModel, ResponseConverter
{
    /** @use SdkModel<VersionDeleteResponseShape> */
    use SdkModel;

    use SdkResponse;

    /**
     * Version identifier for the skill.
     *
     * Each version is identified by a Unix epoch timestamp (e.g., "1759178010641129").
     */
    #[Api]
    public string $id;

    /**
     * Deleted object type.
     *
     * For Skill Versions, this is always `"skill_version_deleted"`.
     */
    #[Api]
    public string $type;

    /**
     * `new VersionDeleteResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * VersionDeleteResponse::with(id: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new VersionDeleteResponse)->withID(...)->withType(...)
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
        string $type = 'skill_version_deleted'
    ): self {
        $obj = new self;

        $obj['id'] = $id;
        $obj['type'] = $type;

        return $obj;
    }

    /**
     * Version identifier for the skill.
     *
     * Each version is identified by a Unix epoch timestamp (e.g., "1759178010641129").
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
     * For Skill Versions, this is always `"skill_version_deleted"`.
     */
    public function withType(string $type): self
    {
        $obj = clone $this;
        $obj['type'] = $type;

        return $obj;
    }
}
