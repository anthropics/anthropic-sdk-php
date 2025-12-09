<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCountTokensContextManagementResponseShape = array{
 *   originalInputTokens: int
 * }
 */
final class BetaCountTokensContextManagementResponse implements BaseModel
{
    /** @use SdkModel<BetaCountTokensContextManagementResponseShape> */
    use SdkModel;

    /**
     * The original token count before context management was applied.
     */
    #[Required('original_input_tokens')]
    public int $originalInputTokens;

    /**
     * `new BetaCountTokensContextManagementResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCountTokensContextManagementResponse::with(originalInputTokens: ...)
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
    public static function with(int $originalInputTokens): self
    {
        $obj = new self;

        $obj['originalInputTokens'] = $originalInputTokens;

        return $obj;
    }

    /**
     * The original token count before context management was applied.
     */
    public function withOriginalInputTokens(int $originalInputTokens): self
    {
        $obj = clone $this;
        $obj['originalInputTokens'] = $originalInputTokens;

        return $obj;
    }
}
