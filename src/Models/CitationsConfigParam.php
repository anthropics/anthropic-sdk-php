<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class CitationsConfigParam implements BaseModel
{
    use Model;

    #[Api(optional: true)]
    public ?bool $enabled;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(?bool $enabled = null)
    {
        self::_introspect();
        $this->unsetOptionalProperties();

        null != $enabled && $this->enabled = $enabled;
    }
}
