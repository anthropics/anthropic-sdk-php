<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaServerToolUseBlockParam\Name;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

final class BetaServerToolUseBlockParam implements BaseModel
{
    use SdkModel;

    #[Api]
    public string $type = 'server_tool_use';

    #[Api]
    public string $id;

    #[Api]
    public mixed $input;

    /** @var Name::* $name */
    #[Api(enum: Name::class)]
    public string $name;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * `new BetaServerToolUseBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaServerToolUseBlockParam::with(id: ..., input: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaServerToolUseBlockParam)->withID(...)->withInput(...)->withName(...)
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
     *
     * @param Name::* $name
     */
    public static function with(
        string $id,
        mixed $input,
        string $name,
        ?BetaCacheControlEphemeral $cacheControl = null,
    ): self {
        $obj = new self;

        $obj->id = $id;
        $obj->input = $input;
        $obj->name = $name;

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
     * @param Name::* $name
     */
    public function withName(string $name): self
    {
        $obj = clone $this;
        $obj->name = $name;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function withCacheControl(
        BetaCacheControlEphemeral $cacheControl
    ): self {
        $obj = clone $this;
        $obj->cacheControl = $cacheControl;

        return $obj;
    }
}
