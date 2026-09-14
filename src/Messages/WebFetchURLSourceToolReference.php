<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * One entry of a tool filter's ``tools``: it must name a tool declared
 * in this request's ``tools[]``.
 *
 * @phpstan-type WebFetchURLSourceToolReferenceShape = array{
 *   name: string, type: 'tool_reference'
 * }
 */
final class WebFetchURLSourceToolReference implements BaseModel
{
    /** @use SdkModel<WebFetchURLSourceToolReferenceShape> */
    use SdkModel;

    /** @var 'tool_reference' $type */
    #[Required]
    public string $type = 'tool_reference';

    #[Required]
    public string $name;

    /**
     * `new WebFetchURLSourceToolReference()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebFetchURLSourceToolReference::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebFetchURLSourceToolReference)->withName(...)
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
