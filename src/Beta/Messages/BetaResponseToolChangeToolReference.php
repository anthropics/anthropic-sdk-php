<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Reference to a single tool, by the name the model uses to call it, as
 * a ``compaction`` block's ``tool_changes`` entry reports it: a tool
 * declared in ``tools`` or defined by an earlier ``tool_addition`` block.
 * Send it back unchanged with the block.
 *
 * @phpstan-type BetaResponseToolChangeToolReferenceShape = array{
 *   name: string, type: 'tool_reference'
 * }
 */
final class BetaResponseToolChangeToolReference implements BaseModel
{
    /** @use SdkModel<BetaResponseToolChangeToolReferenceShape> */
    use SdkModel;

    /** @var 'tool_reference' $type */
    #[Required(type: new ConstantOf('tool_reference'))]
    public string $type = 'tool_reference';

    #[Required]
    public string $name;

    /**
     * `new BetaResponseToolChangeToolReference()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaResponseToolChangeToolReference::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaResponseToolChangeToolReference)->withName(...)
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
     */
    public static function with(string $name): self
    {
        $self = new self;

        $self['name'] = $name;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param 'tool_reference' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
