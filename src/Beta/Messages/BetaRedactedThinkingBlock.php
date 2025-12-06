<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaRedactedThinkingBlockShape = array{
 *   data: string, type: 'redacted_thinking'
 * }
 */
final class BetaRedactedThinkingBlock implements BaseModel
{
    /** @use SdkModel<BetaRedactedThinkingBlockShape> */
    use SdkModel;

    /** @var 'redacted_thinking' $type */
    #[Api]
    public string $type = 'redacted_thinking';

    #[Api]
    public string $data;

    /**
     * `new BetaRedactedThinkingBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRedactedThinkingBlock::with(data: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaRedactedThinkingBlock)->withData(...)
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
