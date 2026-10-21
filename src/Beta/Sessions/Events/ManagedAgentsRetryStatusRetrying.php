<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The server is retrying automatically. Client should wait; the same error type may fire again as retrying, then once as exhausted when the retry budget runs out.
 *
 * @phpstan-type ManagedAgentsRetryStatusRetryingShape = array{type: 'retrying'}
 */
final class ManagedAgentsRetryStatusRetrying implements BaseModel
{
    /** @use SdkModel<ManagedAgentsRetryStatusRetryingShape> */
    use SdkModel;

    /** @var 'retrying' $type */
    #[Required(type: new ConstantOf('retrying'))]
    public string $type = 'retrying';

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
     * @param 'retrying' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
