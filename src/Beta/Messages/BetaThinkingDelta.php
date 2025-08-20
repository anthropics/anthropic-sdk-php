<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_thinking_delta_alias = array{thinking: string, type: string}
 */
final class BetaThinkingDelta implements BaseModel
{
    use SdkModel;

    #[Api]
    public string $type = 'thinking_delta';

    #[Api]
    public string $thinking;

    /**
     * `new BetaThinkingDelta()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaThinkingDelta::with(thinking: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaThinkingDelta)->withThinking(...)
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
    public static function with(string $thinking): self
    {
        $obj = new self;

        $obj->thinking = $thinking;

        return $obj;
    }

    public function withThinking(string $thinking): self
    {
        $obj = clone $this;
        $obj->thinking = $thinking;

        return $obj;
    }
}
