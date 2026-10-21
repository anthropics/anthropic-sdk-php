<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaManagedAgentsBranchCheckoutShape = array{
 *   name: string, type: 'branch'
 * }
 */
final class BetaManagedAgentsBranchCheckout implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsBranchCheckoutShape> */
    use SdkModel;

    /** @var 'branch' $type */
    #[Required(type: new ConstantOf('branch'))]
    public string $type = 'branch';

    /**
     * Branch name to check out.
     */
    #[Required]
    public string $name;

    /**
     * `new BetaManagedAgentsBranchCheckout()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsBranchCheckout::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsBranchCheckout())->withName(...)
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
     * Branch name to check out.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param 'branch' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
