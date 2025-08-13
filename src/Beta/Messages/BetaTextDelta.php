<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_text_delta_alias = array{text: string, type: string}
 */
final class BetaTextDelta implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'text_delta';

    #[Api]
    public string $text;

    /**
     * `new BetaTextDelta()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTextDelta::with(text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaTextDelta)->withText(...)
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
    public static function with(string $text): self
    {
        $obj = new self;

        $obj->text = $text;

        return $obj;
    }

    public function withText(string $text): self
    {
        $obj = clone $this;
        $obj->text = $text;

        return $obj;
    }
}
