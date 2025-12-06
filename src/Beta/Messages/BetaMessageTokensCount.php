<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkResponse;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\Contracts\ResponseConverter;

/**
 * @phpstan-type BetaMessageTokensCountShape = array{
 *   context_management: BetaCountTokensContextManagementResponse|null,
 *   input_tokens: int,
 * }
 */
final class BetaMessageTokensCount implements BaseModel, ResponseConverter
{
    /** @use SdkModel<BetaMessageTokensCountShape> */
    use SdkModel;

    use SdkResponse;

    /**
     * Information about context management applied to the message.
     */
    #[Api]
    public ?BetaCountTokensContextManagementResponse $context_management;

    /**
     * The total number of tokens across the provided list of messages, system prompt, and tools.
     */
    #[Api]
    public int $input_tokens;

    /**
     * `new BetaMessageTokensCount()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMessageTokensCount::with(context_management: ..., input_tokens: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaMessageTokensCount)->withContextManagement(...)->withInputTokens(...)
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
     * @param BetaCountTokensContextManagementResponse|array{
     *   original_input_tokens: int
     * }|null $context_management
     */
    public static function with(
        BetaCountTokensContextManagementResponse|array|null $context_management,
        int $input_tokens,
    ): self {
        $obj = new self;

        $obj['context_management'] = $context_management;
        $obj['input_tokens'] = $input_tokens;

        return $obj;
    }

    /**
     * Information about context management applied to the message.
     *
     * @param BetaCountTokensContextManagementResponse|array{
     *   original_input_tokens: int
     * }|null $contextManagement
     */
    public function withContextManagement(
        BetaCountTokensContextManagementResponse|array|null $contextManagement
    ): self {
        $obj = clone $this;
        $obj['context_management'] = $contextManagement;

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
