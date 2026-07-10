<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Beta\Dreams\BetaDreamMemoryStoreInput\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * An input memory store the dream reads from. The dream never mutates this store.
 *
 * @phpstan-type BetaDreamMemoryStoreInputShape = array{
 *   memoryStoreID: string, type: Type|value-of<Type>
 * }
 */
final class BetaDreamMemoryStoreInput implements BaseModel
{
    /** @use SdkModel<BetaDreamMemoryStoreInputShape> */
    use SdkModel;

    #[Required('memory_store_id')]
    public string $memoryStoreID;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaDreamMemoryStoreInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaDreamMemoryStoreInput::with(memoryStoreID: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaDreamMemoryStoreInput)->withMemoryStoreID(...)->withType(...)
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
