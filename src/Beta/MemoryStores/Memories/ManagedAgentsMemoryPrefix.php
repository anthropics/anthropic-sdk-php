<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryPrefix\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A rolled-up directory marker returned by [List memories](/en/api/beta/memory_stores/memories/list) when `depth` is set. Indicates that one or more memories exist deeper than the requested depth under this prefix. This is a list-time rollup, not a stored resource; it has no ID and no lifecycle. Each prefix counts toward the page `limit` and interleaves with `memory` items in path order.
 *
 * @phpstan-type ManagedAgentsMemoryPrefixShape = array{
 *   path: string, type: Type|value-of<Type>
 * }
 */
final class ManagedAgentsMemoryPrefix implements BaseModel
{
    /** @use SdkModel<ManagedAgentsMemoryPrefixShape> */
    use SdkModel;

    /**
     * The rolled-up path prefix, including a trailing `/` (e.g. `/projects/foo/`). Pass this value as `path_prefix` on a subsequent list call to drill into the directory.
     */
    #[Required]
    public string $path;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsMemoryPrefix()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsMemoryPrefix::with(path: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsMemoryPrefix)->withPath(...)->withType(...)
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
    public static function with(string $path, Type|string $type): self
    {
        $self = new self;

        $self['path'] = $path;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The rolled-up path prefix, including a trailing `/` (e.g. `/projects/foo/`). Pass this value as `path_prefix` on a subsequent list call to drill into the directory.
     */
    public function withPath(string $path): self
    {
        $self = clone $this;
        $self['path'] = $path;

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
