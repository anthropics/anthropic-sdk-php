<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type ManagedAgentsConflictErrorShape = array{
 *   type: 'conflict_error', message?: string|null
 * }
 */
final class ManagedAgentsConflictError implements BaseModel
{
    /** @use SdkModel<ManagedAgentsConflictErrorShape> */
    use SdkModel;

    /** @var 'conflict_error' $type */
    #[Required(type: new ConstantOf('conflict_error'))]
    public string $type = 'conflict_error';

    #[Optional]
    public ?string $message;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $message = null): self
    {
        $self = new self;

        null !== $message && $self['message'] = $message;

        return $self;
    }

    /**
     * @param 'conflict_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
