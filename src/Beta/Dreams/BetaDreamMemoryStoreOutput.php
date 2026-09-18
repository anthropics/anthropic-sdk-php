<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Beta\Dreams\BetaDreamMemoryStoreOutput\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The memory store that holds a dream's result, as an entry in `outputs`.
 *
 * @phpstan-type BetaDreamMemoryStoreOutputShape = array{
 *   memoryStoreID: string, type: Type|value-of<Type>
 * }
 */
final class BetaDreamMemoryStoreOutput implements BaseModel
{
    /** @use SdkModel<BetaDreamMemoryStoreOutputShape> */
    use SdkModel;

    /**
     * The ID of the memory store that the dream writes its result to (`memstore_...`).
     *
     * With `output_behavior` set to `create_new`, this is a new memory store. With `update_existing`, it is the input memory store.
     */
    #[Required('memory_store_id')]
    public string $memoryStoreID;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaDreamMemoryStoreOutput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaDreamMemoryStoreOutput::with(memoryStoreID: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaDreamMemoryStoreOutput)->withMemoryStoreID(...)->withType(...)
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
    public static function with(string $memoryStoreID, Type|string $type): self
    {
        $self = new self;

        $self['memoryStoreID'] = $memoryStoreID;
        $self['type'] = $type;

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
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
