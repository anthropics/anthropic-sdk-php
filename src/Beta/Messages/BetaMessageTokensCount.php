<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaMessageTokensCountShape = array{
 *   contextManagement: BetaCountTokensContextManagementResponse|null,
 *   inputTokens: int,
 * }
 */
final class BetaMessageTokensCount implements BaseModel
{
    /** @use SdkModel<BetaMessageTokensCountShape> */
    use SdkModel;

    /**
     * Information about context management applied to the message.
     */
    #[Required('context_management')]
    public ?BetaCountTokensContextManagementResponse $contextManagement;

    /**
     * The total number of tokens across the provided list of messages, system prompt, and tools.
     */
    #[Required('input_tokens')]
    public int $inputTokens;

    /**
     * `new BetaMessageTokensCount()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMessageTokensCount::with(contextManagement: ..., inputTokens: ...)
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
     *   originalInputTokens: int
     * }|null $contextManagement
     */
    public static function with(
        BetaCountTokensContextManagementResponse|array|null $contextManagement,
        int $inputTokens,
    ): self {
        $obj = new self;

        $obj['contextManagement'] = $contextManagement;
        $obj['inputTokens'] = $inputTokens;

        return $obj;
    }

    /**
     * Information about context management applied to the message.
     *
     * @param BetaCountTokensContextManagementResponse|array{
     *   originalInputTokens: int
     * }|null $contextManagement
     */
    public function withContextManagement(
        BetaCountTokensContextManagementResponse|array|null $contextManagement
    ): self {
        $obj = clone $this;
        $obj['contextManagement'] = $contextManagement;

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
