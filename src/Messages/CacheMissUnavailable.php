<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type CacheMissUnavailableShape = array{type: 'unavailable'}
 */
final class CacheMissUnavailable implements BaseModel
{
    /** @use SdkModel<CacheMissUnavailableShape> */
    use SdkModel;

    /** @var 'unavailable' $type */
    #[Required(type: new ConstantOf('unavailable'))]
    public string $type = 'unavailable';

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
     * @param 'unavailable' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
