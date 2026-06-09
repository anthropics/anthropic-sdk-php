<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsMemoryStoreArchivedRunError\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A memory store referenced by the deployment is archived.
 *
 * @phpstan-type BetaManagedAgentsMemoryStoreArchivedRunErrorShape = array{
 *   message: string, type: Type|value-of<Type>
 * }
 */
final class BetaManagedAgentsMemoryStoreArchivedRunError implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMemoryStoreArchivedRunErrorShape> */
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
     * `new BetaManagedAgentsMemoryStoreArchivedRunError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsMemoryStoreArchivedRunError::with(message: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsMemoryStoreArchivedRunError)
     *   ->withMessage(...)
     *   ->withType(...)
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
