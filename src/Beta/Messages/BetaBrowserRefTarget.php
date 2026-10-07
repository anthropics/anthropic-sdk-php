<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * An element on the page, identified by a reference from a prior `read_page` or
 * `find` result. References are scoped to the tab that produced them and become
 * stale after navigation or a major re-render.
 *
 * @phpstan-type BetaBrowserRefTargetShape = array{ref: string, type: 'ref'}
 */
final class BetaBrowserRefTarget implements BaseModel
{
    /** @use SdkModel<BetaBrowserRefTargetShape> */
    use SdkModel;

    /** @var 'ref' $type */
    #[Required(type: new ConstantOf('ref'))]
    public string $type = 'ref';

    /**
     * An element reference (e.g. "ref_7") returned by a prior `read_page` or `find` result.
     */
    #[Required]
    public string $ref;

    /**
     * `new BetaBrowserRefTarget()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBrowserRefTarget::with(ref: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBrowserRefTarget())->withRef(...)
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
    public static function with(string $ref): self
    {
        $self = new self;

        $self['ref'] = $ref;

        return $self;
    }

    /**
     * An element reference (e.g. "ref_7") returned by a prior `read_page` or `find` result.
     */
    public function withRef(string $ref): self
    {
        $self = clone $this;
        $self['ref'] = $ref;

        return $self;
    }

    /**
     * @param 'ref' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
