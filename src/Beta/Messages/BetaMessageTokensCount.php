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
 *   contextManagement: BetaCountTokensContextManagementResponse|null,
 *   inputTokens: int,
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
    #[Api('context_management')]
    public ?BetaCountTokensContextManagementResponse $contextManagement;

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
     */
    public static function with(
        ?BetaCountTokensContextManagementResponse $contextManagement,
        int $inputTokens,
    ): self {
        $obj = new self;

        $obj->contextManagement = $contextManagement;
        $obj->inputTokens = $inputTokens;

        return $obj;
    }

    /**
     * Information about context management applied to the message.
     */
    public function withContextManagement(
        ?BetaCountTokensContextManagementResponse $contextManagement
    ): self {
        $obj = clone $this;
        $obj->contextManagement = $contextManagement;

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
