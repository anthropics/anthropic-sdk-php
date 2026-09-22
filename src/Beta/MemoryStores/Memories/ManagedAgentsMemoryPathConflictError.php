<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryPathConflictError\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The error returned with HTTP status 409 when a create or rename targets a path that another memory uses, or a path that overlaps another memory's path.
 *
 * Two paths overlap when one is an ancestor of the other, such as `/notes` and `/notes/todo.md`. To free the path, rename or delete the memory that `conflicting_memory_id` references, then retry. To change that memory instead of creating a new one, update it.
 *
 * @phpstan-type ManagedAgentsMemoryPathConflictErrorShape = array{
 *   type: Type|value-of<Type>,
 *   conflictingMemoryID?: string|null,
 *   conflictingPath?: string|null,
 *   message?: string|null,
 * }
 */
final class ManagedAgentsMemoryPathConflictError implements BaseModel
{
    /** @use SdkModel<ManagedAgentsMemoryPathConflictErrorShape> */
    use SdkModel;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

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

    /**
     * `new ManagedAgentsMemoryPathConflictError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsMemoryPathConflictError::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsMemoryPathConflictError)->withType(...)
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
    public static function with(
        Type|string $type,
        ?string $conflictingMemoryID = null,
        ?string $conflictingPath = null,
        ?string $message = null,
    ): self {
        $self = new self;

        $self['type'] = $type;

        null !== $conflictingMemoryID && $self['conflictingMemoryID'] = $conflictingMemoryID;
        null !== $conflictingPath && $self['conflictingPath'] = $conflictingPath;
        null !== $message && $self['message'] = $message;

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
