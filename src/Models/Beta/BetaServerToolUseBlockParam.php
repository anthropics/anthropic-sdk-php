<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaServerToolUseBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    #[Api]
    public mixed $input;

    #[Api]
    public string $name;

    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $id,
        mixed $input,
        string $name,
        string $type,
        ?BetaCacheControlEphemeral $cacheControl = null,
    ) {
        $this->id = $id;
        $this->input = $input;
        $this->name = $name;
        $this->type = $type;
        $this->cacheControl = $cacheControl;
    }
}

BetaServerToolUseBlockParam::_loadMetadata();
