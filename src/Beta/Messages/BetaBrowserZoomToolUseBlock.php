<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type BetaBrowserZoomInputShape from \Anthropic\Beta\Messages\BetaBrowserZoomInput
 * @phpstan-import-type BetaToolUseCallerShape from \Anthropic\Beta\Messages\BetaToolUseCaller
 * @phpstan-import-type BetaToolUseCallerVariants from \Anthropic\Beta\Messages\BetaToolUseCaller
 *
 * @phpstan-type BetaBrowserZoomToolUseBlockShape = array{
 *   id: string,
 *   input: BetaBrowserZoomInput|BetaBrowserZoomInputShape,
 *   name: 'zoom',
 *   toolsetName: 'browser',
 *   type: 'tool_use',
 *   caller?: BetaToolUseCallerShape|null,
 * }
 */
final class BetaBrowserZoomToolUseBlock implements BaseModel
{
    /** @use SdkModel<BetaBrowserZoomToolUseBlockShape> */
    use SdkModel;

    /** @var 'zoom' $name */
    #[Required(type: new ConstantOf('zoom'))]
    public string $name = 'zoom';

    /** @var 'browser' $toolsetName */
    #[Required('toolset_name', type: new ConstantOf('browser'))]
    public string $toolsetName = 'browser';

    /** @var 'tool_use' $type */
    #[Required(type: new ConstantOf('tool_use'))]
    public string $type = 'tool_use';

    #[Required]
    public string $id;

    /**
     * Return a cropped screenshot of the given viewport region, scaled up for closer
     * inspection — useful for small icons, buttons, or text. Coordinates are in the
     * same viewport-pixel space as a full screenshot.
     */
    #[Required]
    public BetaBrowserZoomInput $input;

    /**
     * Which party invoked the tool call: the model directly, or a server tool on its behalf.
     *
     * @var BetaToolUseCallerVariants|null $caller
     */
    #[Optional(union: BetaToolUseCaller::class)]
    public BetaDirectCaller|BetaServerToolCaller|BetaServerToolCaller20260120|null $caller;

    /**
     * `new BetaBrowserZoomToolUseBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBrowserZoomToolUseBlock::with(id: ..., input: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBrowserZoomToolUseBlock())->withID(...)->withInput(...)
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
     * @param BetaBrowserZoomInput|BetaBrowserZoomInputShape $input
     * @param BetaToolUseCallerShape|null $caller
     */
    public static function with(
        string $id,
        BetaBrowserZoomInput|array $input,
        BetaDirectCaller|array|BetaServerToolCaller|BetaServerToolCaller20260120|null $caller = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['input'] = $input;

        null !== $caller && $self['caller'] = $caller;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Return a cropped screenshot of the given viewport region, scaled up for closer
     * inspection — useful for small icons, buttons, or text. Coordinates are in the
     * same viewport-pixel space as a full screenshot.
     *
     * @param BetaBrowserZoomInput|BetaBrowserZoomInputShape $input
     */
    public function withInput(BetaBrowserZoomInput|array $input): self
    {
        $self = clone $this;
        $self['input'] = $input;

        return $self;
    }

    /**
     * @param 'zoom' $name
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param 'browser' $toolsetName
     */
    public function withToolsetName(string $toolsetName): self
    {
        $self = clone $this;
        $self['toolsetName'] = $toolsetName;

        return $self;
    }

    /**
     * @param 'tool_use' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Which party invoked the tool call: the model directly, or a server tool on its behalf.
     *
     * @param BetaToolUseCallerShape $caller
     */
    public function withCaller(
        BetaDirectCaller|array|BetaServerToolCaller|BetaServerToolCaller20260120 $caller,
    ): self {
        $self = clone $this;
        $self['caller'] = $caller;

        return $self;
    }
}
