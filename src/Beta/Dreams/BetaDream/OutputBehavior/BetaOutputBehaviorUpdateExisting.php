<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams\BetaDream\OutputBehavior;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The job writes the consolidated memories into this existing memory store instead of creating one. In EAP the store must be the job's own memory_store input, so the job consolidates the store in place.
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
    #[Required]
    public string $type = 'update_existing';

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
     * (new BetaOutputBehaviorUpdateExisting)->withMemoryStoreID(...)
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
