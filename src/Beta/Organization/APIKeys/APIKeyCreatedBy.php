<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\APIKeys;

use Anthropic\Beta\Organization\APIKeys\APIKeyCreatedBy\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type APIKeyCreatedByShape = array{
 *   id: string, type: Type|value-of<Type>
 * }
 */
final class APIKeyCreatedBy implements BaseModel
{
    /** @use SdkModel<APIKeyCreatedByShape> */
    use SdkModel;

    /**
     * ID of the actor that created the object.
     */
    #[Required]
    public string $id;

    /**
     * Type of the actor that created the object.
     *
     * @var value-of<Type> $type
     */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new APIKeyCreatedBy()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * APIKeyCreatedBy::with(id: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new APIKeyCreatedBy)->withID(...)->withType(...)
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
    public static function with(string $id, Type|string $type): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['type'] = $type;

        return $self;
    }

    /**
     * ID of the actor that created the object.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Type of the actor that created the object.
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
