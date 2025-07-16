<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Messages\BatchCreateParam;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Parameters\Messages\BatchCreateParam\Request\Params;

final class Request implements BaseModel
{
    use Model;

    #[Api('custom_id')]
    public string $customID;

    #[Api]
    public Params $params;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $customID, Params $params)
    {
        $this->customID = $customID;
        $this->params = $params;
    }
}

Request::__introspect();
