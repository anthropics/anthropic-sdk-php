<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The model will not be allowed to use tools.
 *
 * @phpstan-type ToolChoiceNoneShape = array{type: 'none'}
 */
final class ToolChoiceNone implements BaseModel
{
    /** @use SdkModel<ToolChoiceNoneShape> */
    use SdkModel;

    /** @var 'none' $type */
    #[Required(type: new ConstantOf('none'))]
    public string $type = 'none';

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
     * @param 'none' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
