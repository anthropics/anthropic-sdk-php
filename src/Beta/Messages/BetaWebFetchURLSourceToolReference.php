<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * One entry of a tool filter's ``tools``: it must name a tool declared
 * in this request's ``tools[]``.
 *
 * @phpstan-type BetaWebFetchURLSourceToolReferenceShape = array{
 *   name: string, type: 'tool_reference'
 * }
 */
final class BetaWebFetchURLSourceToolReference implements BaseModel
{
    /** @use SdkModel<BetaWebFetchURLSourceToolReferenceShape> */
    use SdkModel;

    /** @var 'tool_reference' $type */
    #[Required(type: new ConstantOf('tool_reference'))]
    public string $type = 'tool_reference';

    #[Required]
    public string $name;

    /**
     * `new BetaWebFetchURLSourceToolReference()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebFetchURLSourceToolReference::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebFetchURLSourceToolReference)->withName(...)
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
