<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaManagedAgentsAgentThinkingPreviewShape = array{
 *   id: string, type: 'agent.thinking'
 * }
 */
final class BetaManagedAgentsAgentThinkingPreview implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAgentThinkingPreviewShape> */
    use SdkModel;

    /** @var 'agent.thinking' $type */
    #[Required(type: new ConstantOf('agent.thinking'))]
    public string $type = 'agent.thinking';

    /**
     * The id the buffered agent.thinking will carry if it is emitted. Start-only — no event_delta events follow.
     */
    #[Required]
    public string $id;

    /**
     * `new BetaManagedAgentsAgentThinkingPreview()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAgentThinkingPreview::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAgentThinkingPreview())->withID(...)
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
     * The id the buffered agent.thinking will carry if it is emitted. Start-only — no event_delta events follow.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param 'agent.thinking' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
