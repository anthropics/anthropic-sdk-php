<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaAdvisorResultBlockShape = array{
 *   stopReason: string|null, text: string, type: 'advisor_result'
 * }
 */
final class BetaAdvisorResultBlock implements BaseModel
{
    /** @use SdkModel<BetaAdvisorResultBlockShape> */
    use SdkModel;

    /** @var 'advisor_result' $type */
    #[Required]
    public string $type = 'advisor_result';

    /**
     * The advisor sub-inference's stop reason (same values as the top-level message `stop_reason`). `max_tokens` indicates the advisor's output was truncated at the tool's `max_tokens` value or the advisor model's policy cap.
     */
    #[Required('stop_reason')]
    public ?string $stopReason;

    #[Required]
    public string $text;

    /**
     * `new BetaAdvisorResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaAdvisorResultBlock::with(stopReason: ..., text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaAdvisorResultBlock)->withStopReason(...)->withText(...)
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
     */
    public static function with(?string $stopReason, string $text): self
    {
        $self = new self;

        $self['stopReason'] = $stopReason;
        $self['text'] = $text;

        return $self;
    }

    /**
     * The advisor sub-inference's stop reason (same values as the top-level message `stop_reason`). `max_tokens` indicates the advisor's output was truncated at the tool's `max_tokens` value or the advisor model's policy cap.
     */
    public function withStopReason(?string $stopReason): self
    {
        $self = clone $this;
        $self['stopReason'] = $stopReason;

        return $self;
    }

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * @param 'advisor_result' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
