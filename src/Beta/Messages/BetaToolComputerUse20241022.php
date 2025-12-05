<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Beta\Messages\BetaToolComputerUse20241022\AllowedCaller;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\MapOf;

/**
 * @phpstan-type BetaToolComputerUse20241022Shape = array{
 *   display_height_px: int,
 *   display_width_px: int,
 *   name: 'computer',
 *   type: 'computer_20241022',
 *   allowed_callers?: list<value-of<AllowedCaller>>|null,
 *   cache_control?: BetaCacheControlEphemeral|null,
 *   defer_loading?: bool|null,
 *   display_number?: int|null,
 *   input_examples?: list<array<string,mixed>>|null,
 *   strict?: bool|null,
 * }
 */
final class BetaToolComputerUse20241022 implements BaseModel
{
    /** @use SdkModel<BetaToolComputerUse20241022Shape> */
    use SdkModel;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     *
     * @var 'computer' $name
     */
    #[Api]
    public string $name = 'computer';

    /** @var 'computer_20241022' $type */
    #[Api]
    public string $type = 'computer_20241022';

    /**
     * The height of the display in pixels.
     */
    #[Api]
    public int $display_height_px;

    /**
     * The width of the display in pixels.
     */
    #[Api]
    public int $display_width_px;

    /** @var list<value-of<AllowedCaller>>|null $allowed_callers */
    #[Api(list: AllowedCaller::class, optional: true)]
    public ?array $allowed_callers;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cache_control;

    /**
     * If true, tool will not be included in initial system prompt. Only loaded when returned via tool_reference from tool search.
     */
    #[Api(optional: true)]
    public ?bool $defer_loading;

    /**
     * The X11 display number (e.g. 0, 1) for the display.
     */
    #[Api(nullable: true, optional: true)]
    public ?int $display_number;

    /** @var list<array<string,mixed>>|null $input_examples */
    #[Api(list: new MapOf('mixed'), optional: true)]
    public ?array $input_examples;

    #[Api(optional: true)]
    public ?bool $strict;

    /**
     * `new BetaToolComputerUse20241022()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolComputerUse20241022::with(display_height_px: ..., display_width_px: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolComputerUse20241022)
     *   ->withDisplayHeightPx(...)
     *   ->withDisplayWidthPx(...)
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
     * @param list<AllowedCaller|value-of<AllowedCaller>> $allowed_callers
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cache_control
     * @param list<array<string,mixed>> $input_examples
     */
    public static function with(
        int $display_height_px,
        int $display_width_px,
        ?array $allowed_callers = null,
        BetaCacheControlEphemeral|array|null $cache_control = null,
        ?bool $defer_loading = null,
        ?int $display_number = null,
        ?array $input_examples = null,
        ?bool $strict = null,
    ): self {
        $obj = new self;

        $obj['display_height_px'] = $display_height_px;
        $obj['display_width_px'] = $display_width_px;

        null !== $allowed_callers && $obj['allowed_callers'] = $allowed_callers;
        null !== $cache_control && $obj['cache_control'] = $cache_control;
        null !== $defer_loading && $obj['defer_loading'] = $defer_loading;
        null !== $display_number && $obj['display_number'] = $display_number;
        null !== $input_examples && $obj['input_examples'] = $input_examples;
        null !== $strict && $obj['strict'] = $strict;

        return $obj;
    }

    /**
     * The height of the display in pixels.
     */
    public function withDisplayHeightPx(int $displayHeightPx): self
    {
        $obj = clone $this;
        $obj['display_height_px'] = $displayHeightPx;

        return $obj;
    }

    /**
     * The width of the display in pixels.
     */
    public function withDisplayWidthPx(int $displayWidthPx): self
    {
        $obj = clone $this;
        $obj['display_width_px'] = $displayWidthPx;

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
     * The X11 display number (e.g. 0, 1) for the display.
     */
    public function withDisplayNumber(?int $displayNumber): self
    {
        $obj = clone $this;
        $obj['display_number'] = $displayNumber;

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
