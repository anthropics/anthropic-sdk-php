<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_thinking_turns = array{type: string, value: int}
 */
final class BetaThinkingTurns implements BaseModel
{
    /** @use SdkModel<beta_thinking_turns> */
    use SdkModel;

    #[Api]
    public string $type = 'thinking_turns';

    #[Api]
    public int $value;

    /**
     * `new BetaThinkingTurns()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaThinkingTurns::with(value: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaThinkingTurns)->withValue(...)
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
    public static function with(int $value): self
    {
        $obj = new self;

        $obj->value = $value;

        return $obj;
    }

    public function withValue(int $value): self
    {
        $obj = clone $this;
        $obj->value = $value;

        return $obj;
    }
}
