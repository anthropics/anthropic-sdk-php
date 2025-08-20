<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_thinking_block_param_alias = array{
 *   signature: string, thinking: string, type: string
 * }
 */
final class BetaThinkingBlockParam implements BaseModel
{
    use SdkModel;

    #[Api]
    public string $type = 'thinking';

    #[Api]
    public string $signature;

    #[Api]
    public string $thinking;

    /**
     * `new BetaThinkingBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaThinkingBlockParam::with(signature: ..., thinking: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaThinkingBlockParam)->withSignature(...)->withThinking(...)
     * ```
     */
    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $signature, string $thinking): self
    {
        $obj = new self;

        $obj->signature = $signature;
        $obj->thinking = $thinking;

        return $obj;
    }

    public function withSignature(string $signature): self
    {
        $obj = clone $this;
        $obj->signature = $signature;

        return $obj;
    }

    public function withThinking(string $thinking): self
    {
        $obj = clone $this;
        $obj->thinking = $thinking;

        return $obj;
    }
}
