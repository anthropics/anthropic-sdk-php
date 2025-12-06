<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type RedactedThinkingBlockParamShape = array{
 *   data: string, type: 'redacted_thinking'
 * }
 */
final class RedactedThinkingBlockParam implements BaseModel
{
    /** @use SdkModel<RedactedThinkingBlockParamShape> */
    use SdkModel;

    /** @var 'redacted_thinking' $type */
    #[Api]
    public string $type = 'redacted_thinking';

    #[Api]
    public string $data;

    /**
     * `new RedactedThinkingBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RedactedThinkingBlockParam::with(data: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RedactedThinkingBlockParam)->withData(...)
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
