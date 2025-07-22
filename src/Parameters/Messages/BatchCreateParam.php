<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Parameters\Messages\BatchCreateParam\Request;

/**
 * Send a batch of Message creation requests.
 *
 * The Message Batches API can be used to process multiple Messages API requests at once. Once a Message Batch is created, it begins processing immediately. Batches can take up to 24 hours to complete.
 *
 * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
 *
 * @phpstan-type create_params = array{requests: list<Request>}
 */
final class BatchCreateParam implements BaseModel
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
     * You must use named parameters to construct this object.
     *
     * @param list<Request> $requests
     */
    final public function __construct(array $requests)
    {
        self::introspect();

        $this->requests = $requests;
    }
}
