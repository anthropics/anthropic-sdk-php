<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Every URL from this source may be fetched. This is the default.
 *
 * @phpstan-type BetaManagedAgentsWebFetchURLSourceAllShape = array{type: 'all'}
 */
final class BetaManagedAgentsWebFetchURLSourceAll implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsWebFetchURLSourceAllShape> */
    use SdkModel;

    /** @var 'all' $type */
    #[Required(type: new ConstantOf('all'))]
    public string $type = 'all';

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
     * @param 'all' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
