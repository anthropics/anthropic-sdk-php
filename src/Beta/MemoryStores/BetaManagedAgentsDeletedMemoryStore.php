<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Confirmation that a `memory_store` was deleted.
 *
 * @phpstan-type BetaManagedAgentsDeletedMemoryStoreShape = array{
 *   id: string, type: 'memory_store_deleted'
 * }
 */
final class BetaManagedAgentsDeletedMemoryStore implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsDeletedMemoryStoreShape> */
    use SdkModel;

    /** @var 'memory_store_deleted' $type */
    #[Required(type: new ConstantOf('memory_store_deleted'))]
    public string $type = 'memory_store_deleted';

    /**
     * ID of the deleted memory store (a `memstore_...` identifier). The store and all its memories and versions are no longer retrievable.
     */
    #[Required]
    public string $id;

    /**
     * `new BetaManagedAgentsDeletedMemoryStore()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsDeletedMemoryStore::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsDeletedMemoryStore())->withID(...)
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
    public static function with(string $id): self
    {
        $self = new self;

        $self['id'] = $id;

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
     * @param 'memory_store_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
