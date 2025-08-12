<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type text_delta_alias = array{text: string, type: string}
 */
final class TextDelta implements BaseModel
{
    use ModelTrait;

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
