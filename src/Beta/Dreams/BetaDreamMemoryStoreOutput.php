<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The memory store that holds a dream's result, as an entry in `outputs`.
 *
 * @phpstan-type BetaDreamMemoryStoreOutputShape = array{
 *   memoryStoreID: string, type: 'memory_store'
 * }
 */
final class BetaDreamMemoryStoreOutput implements BaseModel
{
    /** @use SdkModel<BetaDreamMemoryStoreOutputShape> */
    use SdkModel;

    /** @var 'memory_store' $type */
    #[Required(type: new ConstantOf('memory_store'))]
    public string $type = 'memory_store';

    /**
     * The ID of the memory store that the dream writes its result to (`memstore_...`).
     *
     * With `output_behavior` set to `create_new`, this is a new memory store. With `update_existing`, it is the input memory store.
     */
    #[Required('memory_store_id')]
    public string $memoryStoreID;

    /**
     * `new BetaDreamMemoryStoreOutput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaDreamMemoryStoreOutput::with(memoryStoreID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaDreamMemoryStoreOutput())->withMemoryStoreID(...)
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
     * The ID of the memory store that the dream writes its result to (`memstore_...`).
     *
     * With `output_behavior` set to `create_new`, this is a new memory store. With `update_existing`, it is the input memory store.
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
