<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class ServerToolUseBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $name = 'web_search';

    #[Api]
    public string $type = 'server_tool_use';

    #[Api]
    public string $id;

    #[Api]
    public mixed $input;

    #[Api('cache_control', optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $id,
        mixed $input,
        ?CacheControlEphemeral $cacheControl = null
    ) {
        $this->id = $id;
        $this->input = $input;

        self::_introspect();
        $this->unsetOptionalProperties();

        null != $cacheControl && $this->cacheControl = $cacheControl;
    }
}
