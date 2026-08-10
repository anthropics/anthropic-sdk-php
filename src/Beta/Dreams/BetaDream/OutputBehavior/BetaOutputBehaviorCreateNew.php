<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams\BetaDream\OutputBehavior;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The default destination: the job creates a new output memory store as a clone of the memory_store input and writes the consolidated memories into it. The input store is never mutated.
 *
 * @phpstan-type BetaOutputBehaviorCreateNewShape = array{type: 'create_new'}
 */
final class BetaOutputBehaviorCreateNew implements BaseModel
{
    /** @use SdkModel<BetaOutputBehaviorCreateNewShape> */
    use SdkModel;

    /** @var 'create_new' $type */
    #[Required]
    public string $type = 'create_new';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }

    /**
     * @param 'create_new' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
