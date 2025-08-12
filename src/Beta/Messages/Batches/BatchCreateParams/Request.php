<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches\BatchCreateParams;

use Anthropic\Beta\Messages\Batches\BatchCreateParams\Request\Params;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

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

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function new(string $customID, Params $params): self
    {
        $obj = new self;

        $obj->customID = $customID;
        $obj->params = $params;

        return $obj;
    }

    /**
     * Developer-provided ID created for each request in a Message Batch. Useful for matching results to requests, as results may be given out of request order.
     *
     * Must be unique for each request within the Message Batch.
     */
    public function setCustomID(string $customID): self
    {
        $this->customID = $customID;

        return $this;
    }

    /**
     * Messages API creation parameters for the individual request.
     *
     * See the [Messages API reference](/en/api/messages) for full documentation on available parameters.
     */
    public function setParams(Params $params): self
    {
        $this->params = $params;

        return $this;
    }
}
