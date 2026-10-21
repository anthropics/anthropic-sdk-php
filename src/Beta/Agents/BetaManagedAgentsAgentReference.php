<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A resolved agent reference with a concrete version.
 *
 * @phpstan-type BetaManagedAgentsAgentReferenceShape = array{
 *   id: string, type: 'agent', version: int
 * }
 */
final class BetaManagedAgentsAgentReference implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAgentReferenceShape> */
    use SdkModel;

    /** @var 'agent' $type */
    #[Required(type: new ConstantOf('agent'))]
    public string $type = 'agent';

    #[Required]
    public string $id;

    #[Required]
    public int $version;

    /**
     * `new BetaManagedAgentsAgentReference()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAgentReference::with(id: ..., version: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAgentReference())->withID(...)->withVersion(...)
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
    public static function with(string $id, int $version): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['version'] = $version;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param 'agent' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    public function withVersion(int $version): self
    {
        $self = clone $this;
        $self['version'] = $version;

        return $self;
    }
}
