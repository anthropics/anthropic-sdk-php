<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Beta\Messages\BetaToolSearchToolRegex20251119\AllowedCaller;
use Anthropic\Beta\Messages\BetaToolSearchToolRegex20251119\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaToolSearchToolRegex20251119Shape = array{
 *   name: 'tool_search_tool_regex',
 *   type: value-of<Type>,
 *   allowed_callers?: list<value-of<AllowedCaller>>|null,
 *   cache_control?: BetaCacheControlEphemeral|null,
 *   defer_loading?: bool|null,
 *   strict?: bool|null,
 * }
 */
final class BetaToolSearchToolRegex20251119 implements BaseModel
{
    /** @use SdkModel<BetaToolSearchToolRegex20251119Shape> */
    use SdkModel;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     *
     * @var 'tool_search_tool_regex' $name
     */
    #[Required]
    public string $name = 'tool_search_tool_regex';

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /** @var list<value-of<AllowedCaller>>|null $allowed_callers */
    #[Optional(list: AllowedCaller::class)]
    public ?array $allowed_callers;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional(nullable: true)]
    public ?BetaCacheControlEphemeral $cache_control;

    /**
     * If true, tool will not be included in initial system prompt. Only loaded when returned via tool_reference from tool search.
     */
    #[Optional]
    public ?bool $defer_loading;

    #[Optional]
    public ?bool $strict;

    /**
     * `new BetaToolSearchToolRegex20251119()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolSearchToolRegex20251119::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolSearchToolRegex20251119)->withType(...)
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
     * @param Type|value-of<Type> $type
     * @param list<AllowedCaller|value-of<AllowedCaller>> $allowed_callers
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cache_control
     */
    public static function with(
        Type|string $type,
        ?array $allowed_callers = null,
        BetaCacheControlEphemeral|array|null $cache_control = null,
        ?bool $defer_loading = null,
        ?bool $strict = null,
    ): self {
        $obj = new self;

        $obj['type'] = $type;

        null !== $allowed_callers && $obj['allowed_callers'] = $allowed_callers;
        null !== $cache_control && $obj['cache_control'] = $cache_control;
        null !== $defer_loading && $obj['defer_loading'] = $defer_loading;
        null !== $strict && $obj['strict'] = $strict;

        return $obj;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $obj = clone $this;
        $obj['type'] = $type;

        return $obj;
    }

    /**
     * @param list<AllowedCaller|value-of<AllowedCaller>> $allowedCallers
     */
    public function withAllowedCallers(array $allowedCallers): self
    {
        $obj = clone $this;
        $obj['allowed_callers'] = $allowedCallers;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $obj = clone $this;
        $obj['cache_control'] = $cacheControl;

        return $obj;
    }

    /**
     * If true, tool will not be included in initial system prompt. Only loaded when returned via tool_reference from tool search.
     */
    public function withDeferLoading(bool $deferLoading): self
    {
        $obj = clone $this;
        $obj['defer_loading'] = $deferLoading;

        return $obj;
    }

    public function withStrict(bool $strict): self
    {
        $obj = clone $this;
        $obj['strict'] = $strict;

        return $obj;
    }
}
