<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type text_delta_alias = array{text: string, type: string}
 */
final class TextDelta implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'text_delta';

    #[Api]
    public string $text;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $text)
    {
        self::introspect();

        $this->text = $text;
    }
}
