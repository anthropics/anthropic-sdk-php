<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryPreconditionFailedError\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The error returned with HTTP status 409 when a request's precondition doesn't hold for the memory's current state, such as `precondition` on an update or `expected_content_sha256` on a delete.
 *
 * The error doesn't include the memory's current state. Retrieve the memory to see its current content and `content_sha256` before you retry.
 *
 * See the [memory guide](https://platform.claude.com/docs/en/managed-agents/memory#safe-content-edits-optimistic-concurrency) to learn more about safe content edits with content hash preconditions.
 *
 * @phpstan-type ManagedAgentsMemoryPreconditionFailedErrorShape = array{
 *   type: Type|value-of<Type>, message?: string|null
 * }
 */
final class ManagedAgentsMemoryPreconditionFailedError implements BaseModel
{
    /** @use SdkModel<ManagedAgentsMemoryPreconditionFailedErrorShape> */
    use SdkModel;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * A human-readable explanation of why the precondition failed.
     */
    #[Optional]
    public ?string $message;

    /**
     * `new ManagedAgentsMemoryPreconditionFailedError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsMemoryPreconditionFailedError::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsMemoryPreconditionFailedError)->withType(...)
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
    public static function with(Type|string $type, ?string $message = null): self
    {
        $self = new self;

        $self['type'] = $type;

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
     * A human-readable explanation of why the precondition failed.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
