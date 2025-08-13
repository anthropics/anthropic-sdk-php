<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
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
    use ModelTrait;

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
     * `new ServerToolUseBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ServerToolUseBlockParam::with(id: ..., input: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ServerToolUseBlockParam)->withID(...)->withInput(...)
     * ```
     */
    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        string $id,
        mixed $input,
        ?CacheControlEphemeral $cacheControl = null
    ): self {
        $obj = new self;

        $obj->id = $id;
        $obj->input = $input;

        null !== $cacheControl && $obj->cacheControl = $cacheControl;

        return $obj;
    }

    public function withID(string $id): self
    {
        $obj = clone $this;
        $obj->id = $id;

        return $obj;
    }

    public function withInput(mixed $input): self
    {
        $obj = clone $this;
        $obj->input = $input;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function withCacheControl(CacheControlEphemeral $cacheControl): self
    {
        $obj = clone $this;
        $obj->cacheControl = $cacheControl;

        return $obj;
    }
}
