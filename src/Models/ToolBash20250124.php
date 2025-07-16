<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class ToolBash20250124 implements BaseModel
{
    use Model;

    #[Api]
    public string $name = 'bash';

    #[Api]
    public string $type = 'bash_20250124';

    #[Api('cache_control', optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(?CacheControlEphemeral $cacheControl = null)
    {
        $this->cacheControl = $cacheControl;
    }
}

ToolBash20250124::__introspect();
