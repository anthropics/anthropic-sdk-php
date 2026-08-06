<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsRedactedBlock\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Placeholder for content withheld by Anthropic model policy.
 *
 * @phpstan-type ManagedAgentsRedactedBlockShape = array{type: Type|value-of<Type>}
 */
final class ManagedAgentsRedactedBlock implements BaseModel
{
    /** @use SdkModel<ManagedAgentsRedactedBlockShape> */
    use SdkModel;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsRedactedBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsRedactedBlock::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsRedactedBlock)->withType(...)
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
    public static function with(Type|string $type): self
    {
        $self = new self;

        $self['type'] = $type;

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
