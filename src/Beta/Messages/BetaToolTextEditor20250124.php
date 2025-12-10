<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Beta\Messages\BetaToolTextEditor20250124\AllowedCaller;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\MapOf;

/**
 * @phpstan-type BetaToolTextEditor20250124Shape = array{
 *   name?: 'str_replace_editor',
 *   type?: 'text_editor_20250124',
 *   allowedCallers?: list<value-of<AllowedCaller>>|null,
 *   cacheControl?: BetaCacheControlEphemeral|null,
 *   deferLoading?: bool|null,
 *   inputExamples?: list<array<string,mixed>>|null,
 *   strict?: bool|null,
 * }
 */
final class BetaToolTextEditor20250124 implements BaseModel
{
    /** @use SdkModel<BetaToolTextEditor20250124Shape> */
    use SdkModel;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     *
     * @var 'str_replace_editor' $name
     */
    #[Required]
    public string $name = 'str_replace_editor';

    /** @var 'text_editor_20250124' $type */
    #[Required]
    public string $type = 'text_editor_20250124';

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

    /** @var list<array<string,mixed>>|null $inputExamples */
    #[Optional('input_examples', list: new MapOf('mixed'))]
    public ?array $inputExamples;

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
     * @param list<AllowedCaller|value-of<AllowedCaller>> $allowedCallers
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     * @param list<array<string,mixed>> $inputExamples
     */
    public static function with(
        ?array $allowedCallers = null,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        ?bool $deferLoading = null,
        ?array $inputExamples = null,
        ?bool $strict = null,
    ): self {
        $obj = new self;

        null !== $allowedCallers && $obj['allowedCallers'] = $allowedCallers;
        null !== $cacheControl && $obj['cacheControl'] = $cacheControl;
        null !== $deferLoading && $obj['deferLoading'] = $deferLoading;
        null !== $inputExamples && $obj['inputExamples'] = $inputExamples;
        null !== $strict && $obj['strict'] = $strict;

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

    /**
     * @param list<array<string,mixed>> $inputExamples
     */
    public function withInputExamples(array $inputExamples): self
    {
        $obj = clone $this;
        $obj['inputExamples'] = $inputExamples;

        return $obj;
    }

    public function withStrict(bool $strict): self
    {
        $obj = clone $this;
        $obj['strict'] = $strict;

        return $obj;
    }
}
