<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaManagedAgentsAgentMessagePreviewShape = array{
 *   id: string, type: 'agent.message'
 * }
 */
final class BetaManagedAgentsAgentMessagePreview implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAgentMessagePreviewShape> */
    use SdkModel;

    /** @var 'agent.message' $type */
    #[Required(type: new ConstantOf('agent.message'))]
    public string $type = 'agent.message';

    /**
     * The id the buffered agent.message will carry if it is emitted. Matches the event_id on this preview's event_delta events.
     */
    #[Required]
    public string $id;

    /**
     * `new BetaManagedAgentsAgentMessagePreview()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAgentMessagePreview::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAgentMessagePreview())->withID(...)
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
    public static function with(string $id): self
    {
        $self = new self;

        $self['id'] = $id;

        return $self;
    }

    /**
     * The id the buffered agent.message will carry if it is emitted. Matches the event_id on this preview's event_delta events.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param 'agent.message' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
