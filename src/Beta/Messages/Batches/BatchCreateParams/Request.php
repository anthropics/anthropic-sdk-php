<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches\BatchCreateParams;

use Anthropic\Beta\Messages\Batches\BatchCreateParams\Request\Params;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type RequestShape = array{custom_id: string, params: Params}
 */
final class Request implements BaseModel
{
    /** @use SdkModel<RequestShape> */
    use SdkModel;

    /**
     * Developer-provided ID created for each request in a Message Batch. Useful for matching results to requests, as results may be given out of request order.
     *
     * Must be unique for each request within the Message Batch.
     */
    #[Api]
    public string $custom_id;

    /**
     * Messages API creation parameters for the individual request.
     *
     * See the [Messages API reference](/en/api/messages) for full documentation on available parameters.
     */
    #[Api]
    public Params $params;

    /**
     * `new Request()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Request::with(custom_id: ..., params: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Request)->withCustomID(...)->withParams(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $custom_id, Params $params): self
    {
        $obj = new self;

        $obj->custom_id = $custom_id;
        $obj->params = $params;

        return $obj;
    }

    /**
     * Developer-provided ID created for each request in a Message Batch. Useful for matching results to requests, as results may be given out of request order.
     *
     * Must be unique for each request within the Message Batch.
     */
    public function withCustomID(string $customID): self
    {
        $obj = clone $this;
        $obj->custom_id = $customID;

        return $obj;
    }

    /**
     * Messages API creation parameters for the individual request.
     *
     * See the [Messages API reference](/en/api/messages) for full documentation on available parameters.
     */
    public function withParams(Params $params): self
    {
        $obj = clone $this;
        $obj->params = $params;

        return $obj;
    }
}
