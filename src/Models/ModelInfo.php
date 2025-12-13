<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type ModelInfoShape = array{
 *   id: string, createdAt: \DateTimeInterface, displayName: string, type?: 'model'
 * }
 */
final class ModelInfo implements BaseModel
{
    /** @use SdkModel<ModelInfoShape> */
    use SdkModel;

    /**
     * Object type.
     *
     * For Models, this is always `"model"`.
     *
     * @var 'model' $type
     */
    #[Required]
    public string $type = 'model';

    /**
     * Unique model identifier.
     */
    #[Required]
    public string $id;

    /**
     * RFC 3339 datetime string representing the time at which the model was released. May be set to an epoch value if the release date is unknown.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * A human-readable name for the model.
     */
    #[Required('display_name')]
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
        $this->initialize();
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
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * Unique model identifier.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * RFC 3339 datetime string representing the time at which the model was released. May be set to an epoch value if the release date is unknown.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * A human-readable name for the model.
     */
    public function withDisplayName(string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }
}
