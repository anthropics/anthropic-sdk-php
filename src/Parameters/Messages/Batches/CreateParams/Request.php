<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Messages\Batches\CreateParams;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class Request implements BaseModel
{
    use Model;

    #[Api('custom_id')]
    public string $customID;

    #[Api]
    public Params $params;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string $customID `required`
     * @param Params $params   `required`
     */
    final public function __construct($customID, $params)
    {
        $this->constructFromArgs(func_get_args());
    }
}

Request::_loadMetadata();
