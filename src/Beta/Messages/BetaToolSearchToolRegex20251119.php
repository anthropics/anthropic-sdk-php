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
 *   name?: 'tool_search_tool_regex',
 *   type: value-of<Type>,
 *   allowedCallers?: list<value-of<AllowedCaller>>|null,
 *   cacheControl?: BetaCacheControlEphemeral|null,
 *   deferLoading?: bool|null,
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

    /** @var list<value-of<AllowedCaller>>|null $allowedCallers */
    #[Optional('allowed_callers', list: AllowedCaller::class)]
    public ?array $allowedCallers;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * If true, tool will not be included in initial system prompt. Only loaded when returned via tool_reference from tool search.
     */
    #[Optional('defer_loading')]
    public ?bool $deferLoading;

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
     * @param list<AllowedCaller|value-of<AllowedCaller>> $allowedCallers
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public static function with(
        Type|string $type,
        ?array $allowedCallers = null,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        ?bool $deferLoading = null,
        ?bool $strict = null,
    ): self {
        $obj = new self;

        $obj['type'] = $type;

        null !== $allowedCallers && $obj['allowedCallers'] = $allowedCallers;
        null !== $cacheControl && $obj['cacheControl'] = $cacheControl;
        null !== $deferLoading && $obj['deferLoading'] = $deferLoading;
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
        $obj['allowedCallers'] = $allowedCallers;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $obj = clone $this;
        $obj['cacheControl'] = $cacheControl;

        return $obj;
    }

    /**
     * If true, tool will not be included in initial system prompt. Only loaded when returned via tool_reference from tool search.
     */
    public function withDeferLoading(bool $deferLoading): self
    {
        $obj = clone $this;
        $obj['deferLoading'] = $deferLoading;

        return $obj;
    }

    public function withStrict(bool $strict): self
    {
        $obj = clone $this;
        $obj['strict'] = $strict;

        return $obj;
    }
}
