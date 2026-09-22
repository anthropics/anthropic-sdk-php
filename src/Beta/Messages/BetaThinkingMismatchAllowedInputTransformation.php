<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaThinkingMismatchAllowedInputTransformation\Reason;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaThinkingMismatchAllowedInputTransformationShape = array{
 *   path: string,
 *   reason: Reason|value-of<Reason>,
 *   type: 'thinking_mismatch_allowed',
 * }
 */
final class BetaThinkingMismatchAllowedInputTransformation implements BaseModel
{
    /** @use SdkModel<BetaThinkingMismatchAllowedInputTransformationShape> */
    use SdkModel;

    /**
     * Always `thinking_mismatch_allowed` for this entry type.
     *
     * @var 'thinking_mismatch_allowed' $type
     */
    #[Required(type: new ConstantOf('thinking_mismatch_allowed'))]
    public string $type = 'thinking_mismatch_allowed';

    /**
     * Where the block is in your request, as `messages.{i}.content.{j}`:
     * `i` indexes the `messages` array you sent and `j` that message's `content`
     * array — the same form error messages use.
     */
    #[Required]
    public string $path;

    /**
     * Which binding check the block failed; the block was shown to the model all
     * the same. Always `prefix_binding_mismatch` today — the conversation before
     * the block differs from the conversation it was created in, or the block
     * carries no record of one on a model that requires it. Were the check
     * enforced for this request, the block would have been removed or the request
     * rejected (`thinking.block_binding.prefix_mismatch_behavior`). A removal also
     * takes the rest of that turn's consecutive thinking blocks, whereas here each
     * block is checked on its own, so `thinking_mismatch_allowed` entries are a
     * lower bound on what enforcement would remove.
     *
     * @var value-of<Reason> $reason
     */
    #[Required(enum: Reason::class)]
    public string $reason;

    /**
     * `new BetaThinkingMismatchAllowedInputTransformation()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaThinkingMismatchAllowedInputTransformation::with(path: ..., reason: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaThinkingMismatchAllowedInputTransformation)
     *   ->withPath(...)
     *   ->withReason(...)
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
     * @param Reason|value-of<Reason> $reason
     */
    public static function with(string $path, Reason|string $reason): self
    {
        $self = new self;

        $self['path'] = $path;
        $self['reason'] = $reason;

        return $self;
    }

    /**
     * Where the block is in your request, as `messages.{i}.content.{j}`:
     * `i` indexes the `messages` array you sent and `j` that message's `content`
     * array — the same form error messages use.
     */
    public function withPath(string $path): self
    {
        $self = clone $this;
        $self['path'] = $path;

        return $self;
    }

    /**
     * Which binding check the block failed; the block was shown to the model all
     * the same. Always `prefix_binding_mismatch` today — the conversation before
     * the block differs from the conversation it was created in, or the block
     * carries no record of one on a model that requires it. Were the check
     * enforced for this request, the block would have been removed or the request
     * rejected (`thinking.block_binding.prefix_mismatch_behavior`). A removal also
     * takes the rest of that turn's consecutive thinking blocks, whereas here each
     * block is checked on its own, so `thinking_mismatch_allowed` entries are a
     * lower bound on what enforcement would remove.
     *
     * @param Reason|value-of<Reason> $reason
     */
    public function withReason(Reason|string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }

    /**
     * Always `thinking_mismatch_allowed` for this entry type.
     *
     * @param 'thinking_mismatch_allowed' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
