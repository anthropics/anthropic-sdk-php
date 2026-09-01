<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Controls for block binding: what happens when a thinking block this
 * request sends back fails the conversation check. Every field is optional;
 * an empty object means every default.
 *
 * @phpstan-type BetaThinkingBlockBindingShape = array{
 *   prefixMismatchBehavior?: null|BetaThinkingPrefixMismatchBehavior|value-of<BetaThinkingPrefixMismatchBehavior>,
 * }
 */
final class BetaThinkingBlockBinding implements BaseModel
{
    /** @use SdkModel<BetaThinkingBlockBindingShape> */
    use SdkModel;

    /**
     * What happens when a thinking block in `messages` fails the conversation
     * check: it was created in a different conversation, or the messages before
     * it have changed since. `"error"` (the default) fails the request with a
     * 400 error. `"drop_block"` removes the failing blocks and the request
     * proceeds; the model no longer sees the dropped reasoning.
     *
     * @var value-of<BetaThinkingPrefixMismatchBehavior>|null $prefixMismatchBehavior
     */
    #[Optional(
        'prefix_mismatch_behavior',
        enum: BetaThinkingPrefixMismatchBehavior::class,
        nullable: true,
    )]
    public ?string $prefixMismatchBehavior;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaThinkingPrefixMismatchBehavior|value-of<BetaThinkingPrefixMismatchBehavior>|null $prefixMismatchBehavior
     */
    public static function with(
        BetaThinkingPrefixMismatchBehavior|string|null $prefixMismatchBehavior = null,
    ): self {
        $self = new self;

        null !== $prefixMismatchBehavior && $self['prefixMismatchBehavior'] = $prefixMismatchBehavior;

        return $self;
    }

    /**
     * What happens when a thinking block in `messages` fails the conversation
     * check: it was created in a different conversation, or the messages before
     * it have changed since. `"error"` (the default) fails the request with a
     * 400 error. `"drop_block"` removes the failing blocks and the request
     * proceeds; the model no longer sees the dropped reasoning.
     *
     * @param BetaThinkingPrefixMismatchBehavior|value-of<BetaThinkingPrefixMismatchBehavior>|null $prefixMismatchBehavior
     */
    public function withPrefixMismatchBehavior(
        BetaThinkingPrefixMismatchBehavior|string|null $prefixMismatchBehavior
    ): self {
        $self = clone $this;
        $self['prefixMismatchBehavior'] = $prefixMismatchBehavior;

        return $self;
    }
}
