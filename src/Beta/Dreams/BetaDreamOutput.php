<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Beta\Dreams\BetaDreamOutput\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * An output memory store the dream writes consolidated memories into.
 *
 * @phpstan-type BetaDreamOutputShape = array{
 *   memoryStoreID: string, type: Type|value-of<Type>
 * }
 */
final class BetaDreamOutput implements BaseModel
{
    /** @use SdkModel<BetaDreamOutputShape> */
    use SdkModel;

    #[Required('memory_store_id')]
    public string $memoryStoreID;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaDreamOutput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaDreamOutput::with(memoryStoreID: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaDreamOutput)->withMemoryStoreID(...)->withType(...)
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
