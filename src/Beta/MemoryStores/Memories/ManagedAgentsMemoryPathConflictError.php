<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryPathConflictError\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
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

    #[Optional('conflicting_memory_id')]
    public ?string $conflictingMemoryID;

    #[Optional('conflicting_path')]
    public ?string $conflictingPath;

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

    public function withConflictingMemoryID(string $conflictingMemoryID): self
    {
        $self = clone $this;
        $self['conflictingMemoryID'] = $conflictingMemoryID;

        return $self;
    }

    public function withConflictingPath(string $conflictingPath): self
    {
        $self = clone $this;
        $self['conflictingPath'] = $conflictingPath;

        return $self;
    }

    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
