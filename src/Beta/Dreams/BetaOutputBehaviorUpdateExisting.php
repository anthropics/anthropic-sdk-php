<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Write the result into the input memory store instead of a new memory store.
 *
 * The credential must be allowed to write memory stores, or the request returns a 403 error. While another `update_existing` dream on the same memory store hasn't fully stopped, the request returns a 409 error.
 *
 * @phpstan-type BetaOutputBehaviorUpdateExistingShape = array{
 *   memoryStoreID: string, type: 'update_existing'
 * }
 */
final class BetaOutputBehaviorUpdateExisting implements BaseModel
{
    /** @use SdkModel<BetaOutputBehaviorUpdateExistingShape> */
    use SdkModel;

    /** @var 'update_existing' $type */
    #[Required(type: new ConstantOf('update_existing'))]
    public string $type = 'update_existing';

    /**
     * The ID of the memory store for the dream to write its result to (`memstore_...`). It must be the memory store in the `memory_store` entry of `inputs`.
     */
    #[Required('memory_store_id')]
    public string $memoryStoreID;

    /**
     * `new BetaOutputBehaviorUpdateExisting()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaOutputBehaviorUpdateExisting::with(memoryStoreID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaOutputBehaviorUpdateExisting())->withMemoryStoreID(...)
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
     * The ID of the memory store for the dream to write its result to (`memstore_...`). It must be the memory store in the `memory_store` entry of `inputs`.
     */
    public function withMemoryStoreID(string $memoryStoreID): self
    {
        $self = clone $this;
        $self['memoryStoreID'] = $memoryStoreID;

        return $self;
    }

    /**
     * @param 'update_existing' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
