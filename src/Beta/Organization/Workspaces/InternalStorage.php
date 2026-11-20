<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * No External Storage for this purpose.
 *
 * @phpstan-type InternalStorageShape = array{type: 'internal'}
 */
final class InternalStorage implements BaseModel
{
    /** @use SdkModel<InternalStorageShape> */
    use SdkModel;

    /** @var 'internal' $type */
    #[Required(type: new ConstantOf('internal'))]
    public string $type = 'internal';

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
     * @param 'internal' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
