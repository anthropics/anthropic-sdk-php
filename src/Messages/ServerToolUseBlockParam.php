<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\CacheControlEphemeral\TTL;

/**
 * @phpstan-type ServerToolUseBlockParamShape = array{
 *   id: string,
 *   input: array<string,mixed>,
 *   name?: 'web_search',
 *   type?: 'server_tool_use',
 *   cacheControl?: CacheControlEphemeral|null,
 * }
 */
final class ServerToolUseBlockParam implements BaseModel
{
    /** @use SdkModel<ServerToolUseBlockParamShape> */
    use SdkModel;

    /** @var 'web_search' $name */
    #[Required]
    public string $name = 'web_search';

    /** @var 'server_tool_use' $type */
    #[Required]
    public string $type = 'server_tool_use';

    #[Required]
    public string $id;

    /** @var array<string,mixed> $input */
    #[Required(map: 'mixed')]
    public array $input;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
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
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,mixed> $input
     * @param CacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public static function with(
        string $id,
        array $input,
        CacheControlEphemeral|array|null $cacheControl = null,
    ): self {
        $obj = new self;

        $obj['id'] = $id;
        $obj['input'] = $input;

        null !== $cacheControl && $obj['cacheControl'] = $cacheControl;

        return $obj;
    }

    public function withID(string $id): self
    {
        $obj = clone $this;
        $obj['id'] = $id;

        return $obj;
    }

    /**
     * @param array<string,mixed> $input
     */
    public function withInput(array $input): self
    {
        $obj = clone $this;
        $obj['input'] = $input;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param CacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        CacheControlEphemeral|array|null $cacheControl
    ): self {
        $obj = clone $this;
        $obj['cacheControl'] = $cacheControl;

        return $obj;
    }
}
