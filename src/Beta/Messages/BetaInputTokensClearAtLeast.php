<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaInputTokensClearAtLeastShape = array{
 *   type: 'input_tokens', value: int
 * }
 */
final class BetaInputTokensClearAtLeast implements BaseModel
{
    /** @use SdkModel<BetaInputTokensClearAtLeastShape> */
    use SdkModel;

    /** @var 'input_tokens' $type */
    #[Required]
    public string $type = 'input_tokens';

    #[Required]
    public int $value;

    /**
     * `new BetaInputTokensClearAtLeast()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaInputTokensClearAtLeast::with(value: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaInputTokensClearAtLeast)->withValue(...)
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
