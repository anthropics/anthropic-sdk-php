<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The error returned with HTTP status 409 when you create or rename a memory and the path you give is already used by another memory or overlaps another memory's path.
 *
 * Two paths overlap when one is an ancestor of the other, such as `/notes` and `/notes/todo.md`. To free the path, rename or delete the memory that `conflicting_memory_id` references, then retry. To change that memory instead of creating a new one, update it.
 *
 * @phpstan-type ManagedAgentsMemoryPathConflictErrorShape = array{
 *   type: 'memory_path_conflict_error',
 *   conflictingMemoryID?: string|null,
 *   conflictingPath?: string|null,
 *   message?: string|null,
 * }
 */
final class ManagedAgentsMemoryPathConflictError implements BaseModel
{
    /** @use SdkModel<ManagedAgentsMemoryPathConflictErrorShape> */
    use SdkModel;

    /** @var 'memory_path_conflict_error' $type */
    #[Required(type: new ConstantOf('memory_path_conflict_error'))]
    public string $type = 'memory_path_conflict_error';

    /**
     * The ID of the memory that blocked the write (`mem_...`), or an empty string if that memory can't be identified.
     *
     * Retry the request when it is empty.
     */
    #[Optional('conflicting_memory_id')]
    public ?string $conflictingMemoryID;

    /**
     * The path that blocked the write: the requested path, or the path of a memory that is an ancestor or descendant of it.
     */
    #[Optional('conflicting_path')]
    public ?string $conflictingPath;

    /**
     * A human-readable explanation of the conflict. To handle the error in code, use `conflicting_path` and `conflicting_memory_id` instead.
     */
    #[Optional]
    public ?string $message;

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
        ?string $conflictingMemoryID = null,
        ?string $conflictingPath = null,
        ?string $message = null,
    ): self {
        $self = new self;

        null !== $conflictingMemoryID && $self['conflictingMemoryID'] = $conflictingMemoryID;
        null !== $conflictingPath && $self['conflictingPath'] = $conflictingPath;
        null !== $message && $self['message'] = $message;

        return $self;
    }

    /**
     * @param 'memory_path_conflict_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The ID of the memory that blocked the write (`mem_...`), or an empty string if that memory can't be identified.
     *
     * Retry the request when it is empty.
     */
    public function withConflictingMemoryID(string $conflictingMemoryID): self
    {
        $self = clone $this;
        $self['conflictingMemoryID'] = $conflictingMemoryID;

        return $self;
    }

    /**
     * The path that blocked the write: the requested path, or the path of a memory that is an ancestor or descendant of it.
     */
    public function withConflictingPath(string $conflictingPath): self
    {
        $self = clone $this;
        $self['conflictingPath'] = $conflictingPath;

        return $self;
    }

    /**
     * A human-readable explanation of the conflict. To handle the error in code, use `conflicting_path` and `conflicting_memory_id` instead.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
