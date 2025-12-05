<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkResponse;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\Contracts\ResponseConverter;

/**
 * @phpstan-type MessageTokensCountShape = array{input_tokens: int}
 */
final class MessageTokensCount implements BaseModel, ResponseConverter
{
    /** @use SdkModel<MessageTokensCountShape> */
    use SdkModel;

    use SdkResponse;

    /**
     * The total number of tokens across the provided list of messages, system prompt, and tools.
     */
    #[Api]
    public int $input_tokens;

    /**
     * `new MessageTokensCount()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageTokensCount::with(input_tokens: ...)
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
    public static function with(int $input_tokens): self
    {
        $obj = new self;

        $obj['input_tokens'] = $input_tokens;

        return $obj;
    }

    /**
     * The total number of tokens across the provided list of messages, system prompt, and tools.
     */
    public function withInputTokens(int $inputTokens): self
    {
        $obj = clone $this;
        $obj['input_tokens'] = $inputTokens;

        return $obj;
    }
}
