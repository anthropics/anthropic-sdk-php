<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type MessageTokensCountShape = array{inputTokens: int}
 */
final class MessageTokensCount implements BaseModel
{
    /** @use SdkModel<MessageTokensCountShape> */
    use SdkModel;

    /**
     * The total number of tokens across the provided list of messages, system prompt, and tools.
     */
    #[Required('input_tokens')]
    public int $inputTokens;

    /**
     * `new MessageTokensCount()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageTokensCount::with(inputTokens: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MessageTokensCount)->withInputTokens(...)
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

        $obj['inputTokens'] = $inputTokens;

        return $obj;
    }

    /**
     * The total number of tokens across the provided list of messages, system prompt, and tools.
     */
    public function withInputTokens(int $inputTokens): self
    {
        $obj = clone $this;
        $obj['inputTokens'] = $inputTokens;

        return $obj;
    }
}
