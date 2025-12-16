<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches\BatchCreateParams;

use Anthropic\Beta\Messages\Batches\BatchCreateParams\Request\Params;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ParamsShape from \Anthropic\Beta\Messages\Batches\BatchCreateParams\Request\Params
 *
 * @phpstan-type RequestShape = array{customID: string, params: Params|ParamsShape}
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
    #[Required('custom_id')]
    public string $customID;

    /**
     * Messages API creation parameters for the individual request.
     *
     * See the [Messages API reference](https://docs.claude.com/en/api/messages) for full documentation on available parameters.
     */
    #[Required]
    public Params $params;

    /**
     * `new Request()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Request::with(customID: ..., params: ...)
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
     *
     * @param ParamsShape $params
     */
    public static function with(string $customID, Params|array $params): self
    {
        $self = new self;

        $self['customID'] = $customID;
        $self['params'] = $params;

        return $self;
    }

    /**
     * Developer-provided ID created for each request in a Message Batch. Useful for matching results to requests, as results may be given out of request order.
     *
     * Must be unique for each request within the Message Batch.
     */
    public function withCustomID(string $customID): self
    {
        $self = clone $this;
        $self['customID'] = $customID;

        return $self;
    }

    /**
     * Messages API creation parameters for the individual request.
     *
     * See the [Messages API reference](https://docs.claude.com/en/api/messages) for full documentation on available parameters.
     *
     * @param ParamsShape $params
     */
    public function withParams(Params|array $params): self
    {
        $self = clone $this;
        $self['params'] = $params;

        return $self;
    }
}
