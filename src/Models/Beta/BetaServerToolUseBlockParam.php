<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaServerToolUseBlockParam\Name;

final class BetaServerToolUseBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'server_tool_use';

    #[Api]
    public string $id;

    #[Api]
    public mixed $input;

    /** @var Name::* $name */
    #[Api]
    public string $name;

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object.
     *
     * @param Name::* $name
     */
    final public function __construct(
        string $id,
        mixed $input,
        string $name,
        ?BetaCacheControlEphemeral $cacheControl = null,
    ) {
        $this->id = $id;
        $this->input = $input;
        $this->name = $name;
        $this->cacheControl = $cacheControl;
    }
}

BetaServerToolUseBlockParam::__introspect();
