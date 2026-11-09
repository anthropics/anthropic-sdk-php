<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Returned with status 409 when a request to create a dream sets `output_behavior` to `update_existing` and another dream that writes into the same memory store hasn't fully stopped.
 *
 * The other dream is `pending` or `running`, or it has just stopped and is still finishing its last writes. `message` gives the ID of the other dream when the server can identify it. If that dream has already reached `completed`, `failed`, or `canceled`, retry after a short wait. Otherwise, wait for the other dream to end or cancel it, then retry. The response sets the `x-should-retry` header to `false`.
 *
 * @phpstan-type BetaTargetStoreHeldErrorShape = array{
 *   type: 'conflict_error', message?: string|null
 * }
 */
final class BetaTargetStoreHeldError implements BaseModel
{
    /** @use SdkModel<BetaTargetStoreHeldErrorShape> */
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
