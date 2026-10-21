<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Placeholder for content withheld by Anthropic model policy.
 *
 * @phpstan-type ManagedAgentsRedactedBlockShape = array{type: 'redacted'}
 */
final class ManagedAgentsRedactedBlock implements BaseModel
{
    /** @use SdkModel<ManagedAgentsRedactedBlockShape> */
    use SdkModel;

    /** @var 'redacted' $type */
    #[Required(type: new ConstantOf('redacted'))]
    public string $type = 'redacted';

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
     * @param 'redacted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
