<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaOutputTokensDetailsShape = array{thinkingTokens: int}
 */
final class BetaOutputTokensDetails implements BaseModel
{
    /** @use SdkModel<BetaOutputTokensDetailsShape> */
    use SdkModel;

    /**
     * Number of output tokens the model generated as internal reasoning, including
     * the thinking-block delimiter tokens.
     *
     * Reflects the raw reasoning the model produced, not the (possibly shorter)
     * summarized thinking text returned in the response body. Computed by
     * re-tokenizing the raw reasoning text, so it may differ from the model's exact
     * generation count by a small number of tokens. Always ≤ `output_tokens`;
     * `output_tokens - thinking_tokens` approximates the non-reasoning output.
     */
    #[Required('thinking_tokens')]
    public int $thinkingTokens;

    /**
     * `new BetaOutputTokensDetails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaOutputTokensDetails::with(thinkingTokens: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaOutputTokensDetails)->withThinkingTokens(...)
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
    public static function with(int $thinkingTokens = 0): self
    {
        $self = new self;

        $self['thinkingTokens'] = $thinkingTokens;

        return $self;
    }

    /**
     * Number of output tokens the model generated as internal reasoning, including
     * the thinking-block delimiter tokens.
     *
     * Reflects the raw reasoning the model produced, not the (possibly shorter)
     * summarized thinking text returned in the response body. Computed by
     * re-tokenizing the raw reasoning text, so it may differ from the model's exact
     * generation count by a small number of tokens. Always ≤ `output_tokens`;
     * `output_tokens - thinking_tokens` approximates the non-reasoning output.
     */
    public function withThinkingTokens(int $thinkingTokens): self
    {
        $self = clone $this;
        $self['thinkingTokens'] = $thinkingTokens;

        return $self;
    }
}
