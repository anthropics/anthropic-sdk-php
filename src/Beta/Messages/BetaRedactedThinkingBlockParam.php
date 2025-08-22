<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

final class BetaRedactedThinkingBlockParam implements BaseModel
{
    use SdkModel;

    #[Api]
    public string $type = 'redacted_thinking';

    #[Api]
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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $data): self
    {
        $obj = new self;

        $obj->data = $data;

        return $obj;
    }

    public function withData(string $data): self
    {
        $obj = clone $this;
        $obj->data = $data;

        return $obj;
    }
}
