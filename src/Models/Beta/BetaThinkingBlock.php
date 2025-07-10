<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaThinkingBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $signature;

    #[Api]
    public string $thinking;

    #[Api]
    public string $type;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string $signature `required`
     * @param string $thinking  `required`
     * @param string $type      `required`
     */
    final public function __construct($signature, $thinking, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaThinkingBlock::_loadMetadata();
