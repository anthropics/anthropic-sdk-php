<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class MessageTokensCount implements BaseModel
{
    use Model;

    #[Api('input_tokens')]
    public int $inputTokens;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param int $inputTokens `required`
     */
    final public function __construct($inputTokens)
    {
        $this->constructFromArgs(func_get_args());
    }
}

MessageTokensCount::_loadMetadata();
