<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\TextDelta\Type;

final class TextDelta implements BaseModel
{
    use Model;

    #[Api]
    public string $text;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'text_delta';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(string $text, string $type = 'text_delta')
    {
        $this->text = $text;
        $this->type = $type;
    }
}

TextDelta::_loadMetadata();
