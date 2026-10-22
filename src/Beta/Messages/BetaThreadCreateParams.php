<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Start holding conversation state under this response's ``id``.
 *
 * @phpstan-type BetaThreadCreateParamsShape = array{type: 'create'}
 */
final class BetaThreadCreateParams implements BaseModel
{
    /** @use SdkModel<BetaThreadCreateParamsShape> */
    use SdkModel;

    /** @var 'create' $type */
    #[Required(type: new ConstantOf('create'))]
    public string $type = 'create';

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
     * @param 'create' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
