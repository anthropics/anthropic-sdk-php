<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type server_tool_use_block_param_alias = array{
 *   id: string,
 *   input: mixed,
 *   name: string,
 *   type: string,
 *   cacheControl?: CacheControlEphemeral,
 * }
 */
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

    /**
     * Create a cache control breakpoint at this content block.
     */
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
        self::introspect();
        $this->unsetOptionalProperties();

        $this->id = $id;
        $this->input = $input;

        null !== $cacheControl && $this->cacheControl = $cacheControl;
    }
}
