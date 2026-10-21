<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The turn ended because repeated errors exhausted the retry budget or an error escalated to `retry_status: 'exhausted'`.
 *
 * @phpstan-type ManagedAgentsSessionRetriesExhaustedShape = array{
 *   type: 'retries_exhausted'
 * }
 */
final class ManagedAgentsSessionRetriesExhausted implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSessionRetriesExhaustedShape> */
    use SdkModel;

    /** @var 'retries_exhausted' $type */
    #[Required(type: new ConstantOf('retries_exhausted'))]
    public string $type = 'retries_exhausted';

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
     * @param 'retries_exhausted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
