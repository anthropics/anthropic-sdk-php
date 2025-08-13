<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Messages\Batches\BatchCreateParams\Request;

/**
 * Send a batch of Message creation requests.
 *
 * The Message Batches API can be used to process multiple Messages API requests at once. Once a Message Batch is created, it begins processing immediately. Batches can take up to 24 hours to complete.
 *
 * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
 *
 * @phpstan-type create_params = array{requests: list<Request>}
 */
final class BatchCreateParams implements BaseModel
{
    use Model;
    use Params;

    /**
     * List of requests for prompt completion. Each is an individual request to create a Message.
     *
     * @var list<Request> $requests
     */
    #[Api(type: new ListOf(Request::class))]
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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Request> $requests
     */
    public static function with(array $requests): self
    {
        $obj = new self;

        $obj->requests = $requests;

        return $obj;
    }

    /**
     * List of requests for prompt completion. Each is an individual request to create a Message.
     *
     * @param list<Request> $requests
     */
    public function withRequests(array $requests): self
    {
        $obj = clone $this;
        $obj->requests = $requests;

        return $obj;
    }
}
