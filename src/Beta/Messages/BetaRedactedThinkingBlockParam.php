<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaRedactedThinkingBlockParamShape = array{
 *   data: string, type: 'redacted_thinking'
 * }
 */
final class BetaRedactedThinkingBlockParam implements BaseModel
{
    /** @use SdkModel<BetaRedactedThinkingBlockParamShape> */
    use SdkModel;

    /** @var 'redacted_thinking' $type */
    #[Required]
    public string $type = 'redacted_thinking';

    #[Required]
    public string $data;

    /**
     * `new BetaRedactedThinkingBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRedactedThinkingBlockParam::with(data: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaRedactedThinkingBlockParam)->withData(...)
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
    public static function with(string $data): self
    {
        $obj = new self;

        $obj['data'] = $data;

        return $obj;
    }

    public function withData(string $data): self
    {
        $obj = clone $this;
        $obj['data'] = $data;

        return $obj;
    }
}
