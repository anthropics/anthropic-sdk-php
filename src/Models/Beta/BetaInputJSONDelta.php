<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaInputJSONDelta implements BaseModel
{
    use Model;

    #[Api('partial_json')]
    public string $partialJSON;

    #[Api]
    public string $type = 'input_json_delta';

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string $partialJSON `required`
     * @param string $type        `required`
     */
    final public function __construct($partialJSON, $type = 'input_json_delta')
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaInputJSONDelta::_loadMetadata();
