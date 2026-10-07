<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Names one tool in an only or except list.
 *
 * @phpstan-type BetaManagedAgentsWebFetchURLSourceToolReferenceShape = array{
 *   name: string, type: 'tool_reference'
 * }
 */
final class BetaManagedAgentsWebFetchURLSourceToolReference implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsWebFetchURLSourceToolReferenceShape> */
    use SdkModel;

    /**
     * Must be "tool_reference".
     *
     * @var 'tool_reference' $type
     */
    #[Required(type: new ConstantOf('tool_reference'))]
    public string $type = 'tool_reference';

    /**
     * Name of the tool. Compared exactly, so upper and lower case letters are different.
     */
    #[Required]
    public string $name;

    /**
     * `new BetaManagedAgentsWebFetchURLSourceToolReference()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsWebFetchURLSourceToolReference::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsWebFetchURLSourceToolReference())->withName(...)
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

    /**
     * Name of the tool. Compared exactly, so upper and lower case letters are different.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Must be "tool_reference".
     *
     * @param 'tool_reference' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
