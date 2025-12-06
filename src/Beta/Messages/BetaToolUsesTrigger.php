<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaToolUsesTriggerShape = array{type: 'tool_uses', value: int}
 */
final class BetaToolUsesTrigger implements BaseModel
{
    /** @use SdkModel<BetaToolUsesTriggerShape> */
    use SdkModel;

    /** @var 'tool_uses' $type */
    #[Api]
    public string $type = 'tool_uses';

    #[Api]
    public int $value;

    /**
     * `new BetaToolUsesTrigger()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolUsesTrigger::with(value: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolUsesTrigger)->withValue(...)
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

        $obj['value'] = $value;

        return $obj;
    }

    public function withValue(int $value): self
    {
        $obj = clone $this;
        $obj['value'] = $value;

        return $obj;
    }
}
