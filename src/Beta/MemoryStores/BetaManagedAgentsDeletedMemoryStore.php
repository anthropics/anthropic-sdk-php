<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores;

use Anthropic\Beta\MemoryStores\BetaManagedAgentsDeletedMemoryStore\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Confirmation that a `memory_store` was deleted.
 *
 * @phpstan-type BetaManagedAgentsDeletedMemoryStoreShape = array{
 *   id: string, type: Type|value-of<Type>
 * }
 */
final class BetaManagedAgentsDeletedMemoryStore implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsDeletedMemoryStoreShape> */
    use SdkModel;

    /**
     * ID of the deleted memory store (a `memstore_...` identifier). The store and all its memories and versions are no longer retrievable.
     */
    #[Required]
    public string $id;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsDeletedMemoryStore()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsDeletedMemoryStore::with(id: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsDeletedMemoryStore)->withID(...)->withType(...)
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
     * ID of the deleted memory store (a `memstore_...` identifier). The store and all its memories and versions are no longer retrievable.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
