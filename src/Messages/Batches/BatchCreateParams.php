<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Batches\BatchCreateParams\Request;

/**
 * Send a batch of Message creation requests.
 *
 * The Message Batches API can be used to process multiple Messages API requests at once. Once a Message Batch is created, it begins processing immediately. Batches can take up to 24 hours to complete.
 *
 * Learn more about the Message Batches API in our [user guide](https://docs.claude.com/en/docs/build-with-claude/batch-processing)
 *
 * @see Anthropic\Services\Messages\BatchesService::create()
 *
 * @phpstan-import-type RequestShape from \Anthropic\Messages\Batches\BatchCreateParams\Request
 *
 * @phpstan-type BatchCreateParamsShape = array{requests: list<RequestShape>}
 */
final class BatchCreateParams implements BaseModel
{
    /** @use SdkModel<BatchCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * List of requests for prompt completion. Each is an individual request to create a Message.
     *
     * @var list<Request> $requests
     */
    #[Required(list: Request::class)]
    public array $requests;

    /**
     * `new BatchCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BatchCreateParams::with(requests: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BatchCreateParams)->withRequests(...)
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
     * @param list<RequestShape> $requests
     */
    public static function with(array $requests): self
    {
        $self = new self;

        $self['requests'] = $requests;

        return $self;
    }

    /**
     * List of requests for prompt completion. Each is an individual request to create a Message.
     *
     * @param list<RequestShape> $requests
     */
    public function withRequests(array $requests): self
    {
        $self = clone $this;
        $self['requests'] = $requests;

        return $self;
    }
}
