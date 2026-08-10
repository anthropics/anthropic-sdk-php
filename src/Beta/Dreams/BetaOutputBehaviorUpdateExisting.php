<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Beta\Dreams\BetaOutputBehaviorUpdateExisting\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The job writes the consolidated memories into this existing memory store instead of creating one. In EAP the store must be the job's own memory_store input, so the job consolidates the store in place.
 *
 * @phpstan-type BetaOutputBehaviorUpdateExistingShape = array{
 *   memoryStoreID: string, type: Type|value-of<Type>
 * }
 */
final class BetaOutputBehaviorUpdateExisting implements BaseModel
{
    /** @use SdkModel<BetaOutputBehaviorUpdateExistingShape> */
    use SdkModel;

    #[Required('memory_store_id')]
    public string $memoryStoreID;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaOutputBehaviorUpdateExisting()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaOutputBehaviorUpdateExisting::with(memoryStoreID: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaOutputBehaviorUpdateExisting)->withMemoryStoreID(...)->withType(...)
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
