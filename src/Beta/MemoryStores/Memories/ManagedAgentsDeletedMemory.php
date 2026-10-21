<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The confirmation that [Delete a Memory](https://platform.claude.com/docs/en/api/beta/memory_stores/memories/delete) returns.
 *
 * Deleting a memory doesn't delete its versions. [List Memory Versions](https://platform.claude.com/docs/en/api/beta/memory_stores/memory_versions/list) returns them while they are retained: each version is kept for at least the version retention period after it was written, unless the store itself is deleted.
 *
 * See the [memory guide](https://platform.claude.com/docs/en/managed-agents/memory#audit-memory-changes) to learn more about how long versions are kept.
 *
 * @phpstan-type ManagedAgentsDeletedMemoryShape = array{
 *   id: string, type: 'memory_deleted'
 * }
 */
final class ManagedAgentsDeletedMemory implements BaseModel
{
    /** @use SdkModel<ManagedAgentsDeletedMemoryShape> */
    use SdkModel;

    /** @var 'memory_deleted' $type */
    #[Required(type: new ConstantOf('memory_deleted'))]
    public string $type = 'memory_deleted';

    /**
     * ID of the deleted memory (a `mem_...` value).
     */
    #[Required]
    public string $id;

    /**
     * `new ManagedAgentsDeletedMemory()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsDeletedMemory::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsDeletedMemory())->withID(...)
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
     * ID of the deleted memory (a `mem_...` value).
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param 'memory_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
