<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type RedactedThinkingBlockShape = array{
 *   data: string, type: 'redacted_thinking'
 * }
 */
final class RedactedThinkingBlock implements BaseModel
{
    /** @use SdkModel<RedactedThinkingBlockShape> */
    use SdkModel;

    /** @var 'redacted_thinking' $type */
    #[Required]
    public string $type = 'redacted_thinking';

    #[Required]
    public string $data;

    /**
     * `new RedactedThinkingBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RedactedThinkingBlock::with(data: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RedactedThinkingBlock)->withData(...)
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
