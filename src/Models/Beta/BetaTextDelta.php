<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaTextDelta implements BaseModel
{
    use Model;

    #[Api]
    public string $text;

    #[Api]
    public string $type = 'text_delta';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $text, string $type = 'text_delta')
    {
        $this->text = $text;
        $this->type = $type;
    }
}

BetaTextDelta::_loadMetadata();
