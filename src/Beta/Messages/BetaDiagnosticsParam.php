<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Request-level diagnostics. Currently carries the previous response
 * id for prompt-cache divergence reporting.
 *
 * @phpstan-type BetaDiagnosticsParamShape = array{previousMessageID?: string|null}
 */
final class BetaDiagnosticsParam implements BaseModel
{
    /** @use SdkModel<BetaDiagnosticsParamShape> */
    use SdkModel;

    /**
     * The `id` (`msg_...`) from this client's previous /v1/messages response. The server compares that request's prompt fingerprint against this one and returns `diagnostics.cache_miss_reason` when the prompt-cache prefix could not be reused. Pass `null` on the first turn to opt in without a prior message to compare.
     */
    #[Optional('previous_message_id', nullable: true)]
    public ?string $previousMessageID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $previousMessageID = null): self
    {
        $self = new self;

        null !== $previousMessageID && $self['previousMessageID'] = $previousMessageID;

        return $self;
    }

    /**
     * The `id` (`msg_...`) from this client's previous /v1/messages response. The server compares that request's prompt fingerprint against this one and returns `diagnostics.cache_miss_reason` when the prompt-cache prefix could not be reused. Pass `null` on the first turn to opt in without a prior message to compare.
     */
    public function withPreviousMessageID(?string $previousMessageID): self
    {
        $self = clone $this;
        $self['previousMessageID'] = $previousMessageID;

        return $self;
    }
}
