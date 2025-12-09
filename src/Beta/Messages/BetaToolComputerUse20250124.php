<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Beta\Messages\BetaToolComputerUse20250124\AllowedCaller;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\MapOf;

/**
 * @phpstan-type BetaToolComputerUse20250124Shape = array{
 *   displayHeightPx: int,
 *   displayWidthPx: int,
 *   name?: 'computer',
 *   type?: 'computer_20250124',
 *   allowedCallers?: list<value-of<AllowedCaller>>|null,
 *   cacheControl?: BetaCacheControlEphemeral|null,
 *   deferLoading?: bool|null,
 *   displayNumber?: int|null,
 *   inputExamples?: list<array<string,mixed>>|null,
 *   strict?: bool|null,
 * }
 */
final class BetaToolComputerUse20250124 implements BaseModel
{
    /** @use SdkModel<BetaToolComputerUse20250124Shape> */
    use SdkModel;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     *
     * @var 'computer' $name
     */
    #[Required]
    public string $name = 'computer';

    /** @var 'computer_20250124' $type */
    #[Required]
    public string $type = 'computer_20250124';

    /**
     * The height of the display in pixels.
     */
    #[Required('display_height_px')]
    public int $displayHeightPx;

    /**
     * The width of the display in pixels.
     */
    #[Required('display_width_px')]
    public int $displayWidthPx;

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

    /**
     * The X11 display number (e.g. 0, 1) for the display.
     */
    #[Optional('display_number', nullable: true)]
    public ?int $displayNumber;

    /** @var list<array<string,mixed>>|null $inputExamples */
    #[Optional('input_examples', list: new MapOf('mixed'))]
    public ?array $inputExamples;

    #[Optional]
    public ?bool $strict;

    /**
     * `new BetaToolComputerUse20250124()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolComputerUse20250124::with(displayHeightPx: ..., displayWidthPx: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolComputerUse20250124)
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
     * @param list<AllowedCaller|value-of<AllowedCaller>> $allowedCallers
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     * @param list<array<string,mixed>> $inputExamples
     */
    public static function with(
        int $displayHeightPx,
        int $displayWidthPx,
        ?array $allowedCallers = null,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        ?bool $deferLoading = null,
        ?int $displayNumber = null,
        ?array $inputExamples = null,
        ?bool $strict = null,
    ): self {
        $self = new self;

        $self['displayHeightPx'] = $displayHeightPx;
        $self['displayWidthPx'] = $displayWidthPx;

        null !== $allowedCallers && $self['allowedCallers'] = $allowedCallers;
        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
        null !== $deferLoading && $self['deferLoading'] = $deferLoading;
        null !== $displayNumber && $self['displayNumber'] = $displayNumber;
        null !== $inputExamples && $self['inputExamples'] = $inputExamples;
        null !== $strict && $self['strict'] = $strict;

        return $self;
    }

    /**
     * The height of the display in pixels.
     */
    public function withDisplayHeightPx(int $displayHeightPx): self
    {
        $self = clone $this;
        $self['displayHeightPx'] = $displayHeightPx;

        return $self;
    }

    /**
     * The width of the display in pixels.
     */
    public function withDisplayWidthPx(int $displayWidthPx): self
    {
        $self = clone $this;
        $self['displayWidthPx'] = $displayWidthPx;

        return $self;
    }

    /**
     * @param list<AllowedCaller|value-of<AllowedCaller>> $allowedCallers
     */
    public function withAllowedCallers(array $allowedCallers): self
    {
        $self = clone $this;
        $self['allowedCallers'] = $allowedCallers;

        return $self;
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
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * If true, tool will not be included in initial system prompt. Only loaded when returned via tool_reference from tool search.
     */
    public function withDeferLoading(bool $deferLoading): self
    {
        $self = clone $this;
        $self['deferLoading'] = $deferLoading;

        return $self;
    }

    /**
     * The X11 display number (e.g. 0, 1) for the display.
     */
    public function withDisplayNumber(?int $displayNumber): self
    {
        $self = clone $this;
        $self['displayNumber'] = $displayNumber;

        return $self;
    }

    /**
     * @param list<array<string,mixed>> $inputExamples
     */
    public function withInputExamples(array $inputExamples): self
    {
        $self = clone $this;
        $self['inputExamples'] = $inputExamples;

        return $self;
    }

    public function withStrict(bool $strict): self
    {
        $self = clone $this;
        $self['strict'] = $strict;

        return $self;
    }
}
