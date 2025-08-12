<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaServerToolUseBlockParam\Name;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_server_tool_use_block_param_alias = array{
 *   id: string,
 *   input: mixed,
 *   name: Name::*,
 *   type: string,
 *   cacheControl?: BetaCacheControlEphemeral,
 * }
 */
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
    #[Api(enum: Name::class)]
    public string $name;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

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
    public static function new(
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

    public function setID(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setInput(mixed $input): self
    {
        $this->input = $input;

        return $this;
    }

    /**
     * @param Name::* $name
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function setCacheControl(
        BetaCacheControlEphemeral $cacheControl
    ): self {
        $this->cacheControl = $cacheControl;

        return $this;
    }
}
