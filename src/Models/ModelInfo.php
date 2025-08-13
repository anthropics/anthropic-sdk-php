<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type model_info_alias = array{
 *   id: string, createdAt: \DateTimeInterface, displayName: string, type: string
 * }
 */
final class ModelInfo implements BaseModel
{
    use Model;

    /**
     * Object type.
     *
     * For Models, this is always `"model"`.
     */
    #[Api]
    public string $type = 'model';

    /**
     * Unique model identifier.
     */
    #[Api]
    public string $id;

    /**
     * RFC 3339 datetime string representing the time at which the model was released. May be set to an epoch value if the release date is unknown.
     */
    #[Api('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * A human-readable name for the model.
     */
    #[Api('display_name')]
    public string $displayName;

    /**
     * `new ModelInfo()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ModelInfo::with(id: ..., createdAt: ..., displayName: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ModelInfo)->withID(...)->withCreatedAt(...)->withDisplayName(...)
     * ```
     */
    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        string $displayName
    ): self {
        $obj = new self;

        $obj->id = $id;
        $obj->createdAt = $createdAt;
        $obj->displayName = $displayName;

        return $obj;
    }

    /**
     * Unique model identifier.
     */
    public function withID(string $id): self
    {
        $obj = clone $this;
        $obj->id = $id;

        return $obj;
    }

    /**
     * RFC 3339 datetime string representing the time at which the model was released. May be set to an epoch value if the release date is unknown.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $obj = clone $this;
        $obj->createdAt = $createdAt;

        return $obj;
    }

    /**
     * A human-readable name for the model.
     */
    public function withDisplayName(string $displayName): self
    {
        $obj = clone $this;
        $obj->displayName = $displayName;

        return $obj;
    }
}
