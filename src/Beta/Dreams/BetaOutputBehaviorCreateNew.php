<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Beta\Dreams\BetaOutputBehaviorCreateNew\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The default destination: the job creates a new output memory store as a clone of the memory_store input and writes the consolidated memories into it. The input store is never mutated.
 *
 * @phpstan-type BetaOutputBehaviorCreateNewShape = array{
 *   type: Type|value-of<Type>
 * }
 */
final class BetaOutputBehaviorCreateNew implements BaseModel
{
    /** @use SdkModel<BetaOutputBehaviorCreateNewShape> */
    use SdkModel;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaOutputBehaviorCreateNew()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaOutputBehaviorCreateNew::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaOutputBehaviorCreateNew)->withType(...)
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
    public static function with(Type|string $type): self
    {
        $self = new self;

        $self['type'] = $type;

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
