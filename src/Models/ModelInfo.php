<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkResponse;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\Contracts\ResponseConverter;

/**
 * @phpstan-type ModelInfoShape = array{
 *   id: string,
 *   created_at: \DateTimeInterface,
 *   display_name: string,
 *   type: 'model',
 * }
 */
final class ModelInfo implements BaseModel, ResponseConverter
{
    /** @use SdkModel<ModelInfoShape> */
    use SdkModel;

    use SdkResponse;

    /**
     * Object type.
     *
     * For Models, this is always `"model"`.
     *
     * @var 'model' $type
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
    #[Api]
    public \DateTimeInterface $created_at;

    /**
     * A human-readable name for the model.
     */
    #[Api]
    public string $display_name;

    /**
     * `new ModelInfo()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ModelInfo::with(id: ..., created_at: ..., display_name: ...)
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
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        string $id,
        \DateTimeInterface $created_at,
        string $display_name
    ): self {
        $obj = new self;

        $obj['id'] = $id;
        $obj['created_at'] = $created_at;
        $obj['display_name'] = $display_name;

        return $obj;
    }

    /**
     * Unique model identifier.
     */
    public function withID(string $id): self
    {
        $obj = clone $this;
        $obj['id'] = $id;

        return $obj;
    }

    /**
     * RFC 3339 datetime string representing the time at which the model was released. May be set to an epoch value if the release date is unknown.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $obj = clone $this;
        $obj['created_at'] = $createdAt;

        return $obj;
    }

    /**
     * A human-readable name for the model.
     */
    public function withDisplayName(string $displayName): self
    {
        $obj = clone $this;
        $obj['display_name'] = $displayName;

        return $obj;
    }
}
