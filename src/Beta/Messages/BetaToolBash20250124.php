<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Beta\Messages\BetaToolBash20250124\AllowedCaller;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\MapOf;

/**
 * @phpstan-type BetaToolBash20250124Shape = array{
 *   name: 'bash',
 *   type: 'bash_20250124',
 *   allowed_callers?: list<value-of<AllowedCaller>>|null,
 *   cache_control?: BetaCacheControlEphemeral|null,
 *   defer_loading?: bool|null,
 *   input_examples?: list<array<string,mixed>>|null,
 *   strict?: bool|null,
 * }
 */
final class BetaToolBash20250124 implements BaseModel
{
    /** @use SdkModel<BetaToolBash20250124Shape> */
    use SdkModel;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     *
     * @var 'bash' $name
     */
    #[Required]
    public string $name = 'bash';

    /** @var 'bash_20250124' $type */
    #[Required]
    public string $type = 'bash_20250124';

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

    /** @var list<array<string,mixed>>|null $input_examples */
    #[Optional(list: new MapOf('mixed'))]
    public ?array $input_examples;

    #[Optional]
    public ?bool $strict;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<AllowedCaller|value-of<AllowedCaller>> $allowed_callers
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cache_control
     * @param list<array<string,mixed>> $input_examples
     */
    public static function with(
        ?array $allowed_callers = null,
        BetaCacheControlEphemeral|array|null $cache_control = null,
        ?bool $defer_loading = null,
        ?array $input_examples = null,
        ?bool $strict = null,
    ): self {
        $obj = new self;

        null !== $allowed_callers && $obj['allowed_callers'] = $allowed_callers;
        null !== $cache_control && $obj['cache_control'] = $cache_control;
        null !== $defer_loading && $obj['defer_loading'] = $defer_loading;
        null !== $input_examples && $obj['input_examples'] = $input_examples;
        null !== $strict && $obj['strict'] = $strict;

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

    /**
     * @param list<array<string,mixed>> $inputExamples
     */
    public function withInputExamples(array $inputExamples): self
    {
        $obj = clone $this;
        $obj['input_examples'] = $inputExamples;

        return $obj;
    }

    public function withStrict(bool $strict): self
    {
        $obj = clone $this;
        $obj['strict'] = $strict;

        return $obj;
    }
}
