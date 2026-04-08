<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsSendSessionEvents\Data;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Events that were successfully sent to the session.
 *
 * @phpstan-import-type DataVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsSendSessionEvents\Data
 * @phpstan-import-type DataShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSendSessionEvents\Data
 *
 * @phpstan-type ManagedAgentsSendSessionEventsShape = array{
 *   data?: list<DataShape>|null
 * }
 */
final class ManagedAgentsSendSessionEvents implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSendSessionEventsShape> */
    use SdkModel;

    /**
     * Sent events.
     *
     * @var list<DataVariants>|null $data
     */
    #[Optional(list: Data::class)]
    public ?array $data;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<DataShape>|null $data
     */
    public static function with(?array $data = null): self
    {
        $self = new self;

        null !== $data && $self['data'] = $data;

        return $self;
    }

    /**
     * Sent events.
     *
     * @param list<DataShape> $data
     */
    public function withData(array $data): self
    {
        $self = clone $this;
        $self['data'] = $data;

        return $self;
    }
}
