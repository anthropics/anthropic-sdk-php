<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Sessions\BetaManagedAgentsMemoryStoreResourceParam\Access;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Parameters for attaching a memory store to an agent session.
 *
 * @phpstan-type BetaManagedAgentsMemoryStoreResourceParamShape = array{
 *   memoryStoreID: string,
 *   type: 'memory_store',
 *   access?: null|Access|value-of<Access>,
 *   instructions?: string|null,
 * }
 */
final class BetaManagedAgentsMemoryStoreResourceParam implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMemoryStoreResourceParamShape> */
    use SdkModel;

    /** @var 'memory_store' $type */
    #[Required(type: new ConstantOf('memory_store'))]
    public string $type = 'memory_store';

    /**
     * The memory store ID (memstore_...). Must belong to the caller's organization and workspace.
     */
    #[Required('memory_store_id')]
    public string $memoryStoreID;

    /**
     * Access mode for the mounted store. Defaults to read_write. read_only mounts the store as a read-only filesystem.
     *
     * @var value-of<Access>|null $access
     */
    #[Optional(enum: Access::class, nullable: true)]
    public ?string $access;

    /**
     * Per-attachment guidance for the agent on how to use this store. Rendered into the memory section of the system prompt. Max 4096 chars.
     */
    #[Optional(nullable: true)]
    public ?string $instructions;

    /**
     * `new BetaManagedAgentsMemoryStoreResourceParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsMemoryStoreResourceParam::with(memoryStoreID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsMemoryStoreResourceParam())->withMemoryStoreID(...)
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
     * @param Access|value-of<Access>|null $access
     */
    public static function with(
        string $memoryStoreID,
        Access|string|null $access = null,
        ?string $instructions = null,
    ): self {
        $self = new self;

        $self['memoryStoreID'] = $memoryStoreID;

        null !== $access && $self['access'] = $access;
        null !== $instructions && $self['instructions'] = $instructions;

        return $self;
    }

    /**
     * The memory store ID (memstore_...). Must belong to the caller's organization and workspace.
     */
    public function withMemoryStoreID(string $memoryStoreID): self
    {
        $self = clone $this;
        $self['memoryStoreID'] = $memoryStoreID;

        return $self;
    }

    /**
     * @param 'memory_store' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Access mode for the mounted store. Defaults to read_write. read_only mounts the store as a read-only filesystem.
     *
     * @param Access|value-of<Access>|null $access
     */
    public function withAccess(Access|string|null $access): self
    {
        $self = clone $this;
        $self['access'] = $access;

        return $self;
    }

    /**
     * Per-attachment guidance for the agent on how to use this store. Rendered into the memory section of the system prompt. Max 4096 chars.
     */
    public function withInstructions(?string $instructions): self
    {
        $self = clone $this;
        $self['instructions'] = $instructions;

        return $self;
    }
}
