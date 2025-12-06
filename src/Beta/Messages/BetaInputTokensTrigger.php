<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaInputTokensTriggerShape = array{
 *   type: 'input_tokens', value: int
 * }
 */
final class BetaInputTokensTrigger implements BaseModel
{
    /** @use SdkModel<BetaInputTokensTriggerShape> */
    use SdkModel;

    /** @var 'input_tokens' $type */
    #[Api]
    public string $type = 'input_tokens';

    #[Api]
    public int $value;

    /**
     * `new BetaInputTokensTrigger()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaInputTokensTrigger::with(value: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaInputTokensTrigger)->withValue(...)
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
