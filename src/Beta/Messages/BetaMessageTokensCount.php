<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_message_tokens_count = array{inputTokens: int}
 * When used in a response, this type parameter can define a $rawResponse property.
 * @template TRawResponse of object = object{}
 *
 * @mixin TRawResponse
 */
final class BetaMessageTokensCount implements BaseModel
{
    /** @use SdkModel<beta_message_tokens_count> */
    use SdkModel;

    /**
     * The total number of tokens across the provided list of messages, system prompt, and tools.
     */
    #[Api('input_tokens')]
    public int $inputTokens;

    /**
     * `new BetaMessageTokensCount()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMessageTokensCount::with(inputTokens: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaMessageTokensCount)->withInputTokens(...)
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
    public static function with(int $inputTokens): self
    {
        $obj = new self;

        $obj->inputTokens = $inputTokens;

        return $obj;
    }

    /**
     * The total number of tokens across the provided list of messages, system prompt, and tools.
     */
    public function withInputTokens(int $inputTokens): self
    {
        $obj = clone $this;
        $obj->inputTokens = $inputTokens;

        return $obj;
    }
}
