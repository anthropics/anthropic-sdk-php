<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCountTokensContextManagementResponseShape = array{
 *   original_input_tokens: int
 * }
 */
final class BetaCountTokensContextManagementResponse implements BaseModel
{
    /** @use SdkModel<BetaCountTokensContextManagementResponseShape> */
    use SdkModel;

    /**
     * The original token count before context management was applied.
     */
    #[Api]
    public int $original_input_tokens;

    /**
     * `new BetaCountTokensContextManagementResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCountTokensContextManagementResponse::with(original_input_tokens: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCountTokensContextManagementResponse)->withOriginalInputTokens(...)
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
    public static function with(int $original_input_tokens): self
    {
        $obj = new self;

        $obj['original_input_tokens'] = $original_input_tokens;

        return $obj;
    }

    /**
     * The original token count before context management was applied.
     */
    public function withOriginalInputTokens(int $originalInputTokens): self
    {
        $obj = clone $this;
        $obj['original_input_tokens'] = $originalInputTokens;

        return $obj;
    }
}
