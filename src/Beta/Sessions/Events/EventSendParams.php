<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Send Events.
 *
 * @see Anthropic\Services\Beta\Sessions\EventsService::send()
 *
 * @phpstan-import-type ManagedAgentsEventParamsVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsEventParams
 * @phpstan-import-type ManagedAgentsEventParamsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsEventParams
 *
 * @phpstan-type EventSendParamsShape = array{
 *   events: list<ManagedAgentsEventParamsShape>,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class EventSendParams implements BaseModel
{
    /** @use SdkModel<EventSendParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Events to send to the `session`.
     *
     * @var list<ManagedAgentsEventParamsVariants> $events
     */
    #[Required(list: ManagedAgentsEventParams::class)]
    public array $events;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new EventSendParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * EventSendParams::with(events: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new EventSendParams)->withEvents(...)
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
     *
     * @param list<ManagedAgentsEventParamsShape> $events
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(array $events, ?array $betas = null): self
    {
        $self = new self;

        $self['events'] = $events;

        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Events to send to the `session`.
     *
     * @param list<ManagedAgentsEventParamsShape> $events
     */
    public function withEvents(array $events): self
    {
        $self = clone $this;
        $self['events'] = $events;

        return $self;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
