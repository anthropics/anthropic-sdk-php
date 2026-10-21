<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Specification for an Agent. Provide a specific `version` or use the short-form `agent="agent_id"` for the most recent version.
 *
 * @phpstan-type BetaManagedAgentsAgentParamsShape = array{
 *   id: string, type: 'agent', version?: int|null
 * }
 */
final class BetaManagedAgentsAgentParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAgentParamsShape> */
    use SdkModel;

    /** @var 'agent' $type */
    #[Required(type: new ConstantOf('agent'))]
    public string $type = 'agent';

    /**
     * The `agent` ID.
     */
    #[Required]
    public string $id;

    /**
     * The specific `agent` version to use. Omit to use the latest version. Must be at least 1 if specified.
     */
    #[Optional]
    public ?int $version;

    /**
     * `new BetaManagedAgentsAgentParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAgentParams::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAgentParams())->withID(...)
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
    public static function with(string $id, ?int $version = null): self
    {
        $self = new self;

        $self['id'] = $id;

        null !== $version && $self['version'] = $version;

        return $self;
    }

    /**
     * The `agent` ID.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param 'agent' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The specific `agent` version to use. Omit to use the latest version. Must be at least 1 if specified.
     */
    public function withVersion(int $version): self
    {
        $self = clone $this;
        $self['version'] = $version;

        return $self;
    }
}
