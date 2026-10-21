<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The memory store that a dream reads, given as an entry in `inputs`.
 *
 * With `output_behavior` set to `update_existing`, the dream writes its result into this memory store. Otherwise the dream doesn't change it.
 *
 * @phpstan-type BetaDreamMemoryStoreInputShape = array{
 *   memoryStoreID: string, type: 'memory_store'
 * }
 */
final class BetaDreamMemoryStoreInput implements BaseModel
{
    /** @use SdkModel<BetaDreamMemoryStoreInputShape> */
    use SdkModel;

    /** @var 'memory_store' $type */
    #[Required(type: new ConstantOf('memory_store'))]
    public string $type = 'memory_store';

    /**
     * The ID of the memory store for the dream to read (`memstore_...`).
     *
     * The memory store must be in the same workspace as the dream and must not be archived.
     */
    #[Required('memory_store_id')]
    public string $memoryStoreID;

    /**
     * `new BetaDreamMemoryStoreInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaDreamMemoryStoreInput::with(memoryStoreID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaDreamMemoryStoreInput())->withMemoryStoreID(...)
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
    public static function with(string $memoryStoreID): self
    {
        $self = new self;

        $self['memoryStoreID'] = $memoryStoreID;

        return $self;
    }

    /**
     * The ID of the memory store for the dream to read (`memstore_...`).
     *
     * The memory store must be in the same workspace as the dream and must not be archived.
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
}
