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
    public static function from(string $text): self
    {
        $obj = new self;

        $obj->text = $text;

        return $obj;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }
}
