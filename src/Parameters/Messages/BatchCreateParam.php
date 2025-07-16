<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Parameters\Messages\BatchCreateParam\Request;

final class BatchCreateParam implements BaseModel
{
    use Model;
    use Params;

    /** @var list<Request> $requests */
    #[Api(type: new ListOf(Request::class))]
    public array $requests;

    /**
     * You must use named parameters to construct this object.
     *
     * @param list<Request> $requests
     */
    final public function __construct(array $requests)
    {
        $this->requests = $requests;

        self::_introspect();
    }
}
