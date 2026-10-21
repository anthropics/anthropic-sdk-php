<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Tool calls require user confirmation before execution.
 *
 * @phpstan-type BetaManagedAgentsAlwaysAskPolicyShape = array{type: 'always_ask'}
 */
final class BetaManagedAgentsAlwaysAskPolicy implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAlwaysAskPolicyShape> */
    use SdkModel;

    /** @var 'always_ask' $type */
    #[Required(type: new ConstantOf('always_ask'))]
    public string $type = 'always_ask';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }

    /**
     * @param 'always_ask' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
