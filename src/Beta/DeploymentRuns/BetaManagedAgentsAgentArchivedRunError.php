<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsAgentArchivedRunError\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The deployment's agent was archived.
 *
 * @phpstan-type BetaManagedAgentsAgentArchivedRunErrorShape = array{
 *   message: string, type: Type|value-of<Type>
 * }
 */
final class BetaManagedAgentsAgentArchivedRunError implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAgentArchivedRunErrorShape> */
    use SdkModel;

    /**
     * Human-readable error description.
     */
    #[Required]
    public string $message;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsAgentArchivedRunError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAgentArchivedRunError::with(message: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAgentArchivedRunError)->withMessage(...)->withType(...)
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
     * @param Type|value-of<Type> $type
     */
    public static function with(string $message, Type|string $type): self
    {
        $self = new self;

        $self['message'] = $message;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Human-readable error description.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
