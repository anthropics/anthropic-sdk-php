<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type ThinkingDeltaShape = array{
 *   thinking: string, type: 'thinking_delta'
 * }
 */
final class ThinkingDelta implements BaseModel
{
    /** @use SdkModel<ThinkingDeltaShape> */
    use SdkModel;

    /** @var 'thinking_delta' $type */
    #[Api]
    public string $type = 'thinking_delta';

    #[Api]
    public string $thinking;

    /**
     * `new ThinkingDelta()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ThinkingDelta::with(thinking: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ThinkingDelta)->withThinking(...)
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
    public static function with(string $thinking): self
    {
        $obj = new self;

        $obj['thinking'] = $thinking;

        return $obj;
    }

    public function withThinking(string $thinking): self
    {
        $obj = clone $this;
        $obj['thinking'] = $thinking;

        return $obj;
    }
}
