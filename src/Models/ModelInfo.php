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
    public static function new(
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
    public function setID(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * RFC 3339 datetime string representing the time at which the model was released. May be set to an epoch value if the release date is unknown.
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * A human-readable name for the model.
     */
    public function setDisplayName(string $displayName): self
    {
        $this->displayName = $displayName;

        return $this;
    }
}
