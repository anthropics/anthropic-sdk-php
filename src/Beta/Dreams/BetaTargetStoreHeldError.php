<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The `output_behavior.memory_store_id` target is still held by a prior `{type: "update_existing"}` dream — one that is `pending` or `running`, or was canceled with its final writes still landing. Rarely the named dream has just finished (`completed`/`failed`) and its execution is still closing; an immediate retry then almost always succeeds. The message names the holding dream when the server can identify it (rarely omitted); poll it to a terminal state or cancel it, then retry. Carried with `x-should-retry: false`.
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
    #[Required]
    public string $type = 'conflict_error';

    /**
     * Human-readable description of the conflict, naming the dream that holds the target store when the server can identify it.
     */
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

    /**
     * Human-readable description of the conflict, naming the dream that holds the target store when the server can identify it.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
