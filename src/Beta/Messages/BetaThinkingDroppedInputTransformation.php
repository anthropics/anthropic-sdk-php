<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaThinkingDroppedInputTransformation\Reason;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaThinkingDroppedInputTransformationShape = array{
 *   path: string, reason: Reason|value-of<Reason>, type: 'thinking_dropped'
 * }
 */
final class BetaThinkingDroppedInputTransformation implements BaseModel
{
    /** @use SdkModel<BetaThinkingDroppedInputTransformationShape> */
    use SdkModel;

    /**
     * Always `thinking_dropped` for this entry type.
     *
     * @var 'thinking_dropped' $type
     */
    #[Required]
    public string $type = 'thinking_dropped';

    /**
     * Where the removed block was in your request, as `messages.{i}.content.{j}`:
     * `i` indexes the `messages` array you sent and `j` that message's `content`
     * array — the same form error messages use.
     */
    #[Required]
    public string $path;

    /**
     * Which binding check removed the block: `model_binding_mismatch` — it was
     * created by a model whose reasoning the requested model may not read;
     * `prefix_binding_mismatch` — the conversation before it differs from the
     * conversation it was created in (the rest of that turn's consecutive thinking
     * blocks are removed with it, each with this reason);
     * `organization_binding_mismatch` — it was created under a different
     * organization (an Anthropic organization, AWS account or Google Cloud project)
     * and this organization is not one of its additional organizations;
     * `end_user_binding_mismatch` — it was created for a different end user, or
     * was removed by the consumer-organization binding. A block that would fail
     * several checks reports one reason, in this order of precedence:
     * `organization_binding_mismatch`, `end_user_binding_mismatch`,
     * `model_binding_mismatch`, `prefix_binding_mismatch`.
     *
     * @var value-of<Reason> $reason
     */
    #[Required(enum: Reason::class)]
    public string $reason;

    /**
     * `new BetaThinkingDroppedInputTransformation()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaThinkingDroppedInputTransformation::with(path: ..., reason: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaThinkingDroppedInputTransformation)->withPath(...)->withReason(...)
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
     * Where the removed block was in your request, as `messages.{i}.content.{j}`:
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
     * Which binding check removed the block: `model_binding_mismatch` — it was
     * created by a model whose reasoning the requested model may not read;
     * `prefix_binding_mismatch` — the conversation before it differs from the
     * conversation it was created in (the rest of that turn's consecutive thinking
     * blocks are removed with it, each with this reason);
     * `organization_binding_mismatch` — it was created under a different
     * organization (an Anthropic organization, AWS account or Google Cloud project)
     * and this organization is not one of its additional organizations;
     * `end_user_binding_mismatch` — it was created for a different end user, or
     * was removed by the consumer-organization binding. A block that would fail
     * several checks reports one reason, in this order of precedence:
     * `organization_binding_mismatch`, `end_user_binding_mismatch`,
     * `model_binding_mismatch`, `prefix_binding_mismatch`.
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
     * Always `thinking_dropped` for this entry type.
     *
     * @param 'thinking_dropped' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
