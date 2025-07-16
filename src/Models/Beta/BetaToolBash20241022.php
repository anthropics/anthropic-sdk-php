<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaToolBash20241022 implements BaseModel
{
    use Model;

    #[Api]
    public string $name = 'bash';

    #[Api]
    public string $type = 'bash_20241022';

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        ?BetaCacheControlEphemeral $cacheControl = null
    ) {
        $this->cacheControl = $cacheControl;
    }
}

BetaToolBash20241022::_loadMetadata();
