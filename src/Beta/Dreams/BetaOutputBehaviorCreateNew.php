<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Write the result to a new memory store that starts as a copy of the input memory store. This is the default.
 *
 * The new memory store is in the same workspace as the dream. The dream doesn't change the input memory store.
 *
 * @phpstan-type BetaOutputBehaviorCreateNewShape = array{type: 'create_new'}
 */
final class BetaOutputBehaviorCreateNew implements BaseModel
{
    /** @use SdkModel<BetaOutputBehaviorCreateNewShape> */
    use SdkModel;

    /** @var 'create_new' $type */
    #[Required(type: new ConstantOf('create_new'))]
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
