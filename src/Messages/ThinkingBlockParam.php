<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type ThinkingBlockParamShape = array{
 *   signature: string, thinking: string, type: 'thinking'
 * }
 */
final class ThinkingBlockParam implements BaseModel
{
    /** @use SdkModel<ThinkingBlockParamShape> */
    use SdkModel;

    /** @var 'thinking' $type */
    #[Api]
    public string $type = 'thinking';

    #[Api]
    public string $signature;

    #[Api]
    public string $thinking;

    /**
     * `new ThinkingBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ThinkingBlockParam::with(signature: ..., thinking: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ThinkingBlockParam)->withSignature(...)->withThinking(...)
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
    public static function with(string $signature, string $thinking): self
    {
        $obj = new self;

        $obj['signature'] = $signature;
        $obj['thinking'] = $thinking;

        return $obj;
    }

    public function withSignature(string $signature): self
    {
        $obj = clone $this;
        $obj['signature'] = $signature;

        return $obj;
    }

    public function withThinking(string $thinking): self
    {
        $obj = clone $this;
        $obj['thinking'] = $thinking;

        return $obj;
    }
}
