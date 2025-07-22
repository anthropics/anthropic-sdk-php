<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Beta\Messages\BatchCreateParam;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Parameters\Beta\Messages\BatchCreateParam\Request\Params;

/**
 * @phpstan-type request_alias = array{customID: string, params: Params}
 */
final class Request implements BaseModel
{
    use Model;

    /**
     * Developer-provided ID created for each request in a Message Batch. Useful for matching results to requests, as results may be given out of request order.
     *
     * Must be unique for each request within the Message Batch.
     */
    #[Api('custom_id')]
    public string $customID;

    /**
     * Messages API creation parameters for the individual request.
     *
     * See the [Messages API reference](/en/api/messages) for full documentation on available parameters.
     */
    #[Api]
    public Params $params;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $customID, Params $params)
    {
        self::introspect();

        $this->customID = $customID;
        $this->params = $params;
    }
}
