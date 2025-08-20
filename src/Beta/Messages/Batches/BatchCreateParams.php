<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Messages\Batches\BatchCreateParams\Request;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Core\Conversion\UnionOf;

/**
 * Send a batch of Message creation requests.
 *
 * The Message Batches API can be used to process multiple Messages API requests at once. Once a Message Batch is created, it begins processing immediately. Batches can take up to 24 hours to complete.
 *
 * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
 *
 * @phpstan-type create_params = array{
 *   requests: list<Request>, betas?: list<AnthropicBeta::*|string>
 * }
 */
final class BatchCreateParams implements BaseModel
{
    use SdkModel;
    use SdkParams;

    /**
     * List of requests for prompt completion. Each is an individual request to create a Message.
     *
     * @var list<Request> $requests
     */
    #[Api(type: new ListOf(Request::class))]
    public array $requests;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<AnthropicBeta::*|string>|null $betas
     */
    #[Api(
        type: new ListOf(union: new UnionOf([AnthropicBeta::class, 'string'])),
        optional: true,
    )]
    public ?array $betas;

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
     * @param list<AnthropicBeta::*|string>|null $betas
     */
    public static function with(array $requests, ?array $betas = null): self
    {
        $obj = new self;

        $obj->requests = $requests;

        null !== $betas && $obj->betas = $betas;

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

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<AnthropicBeta::*|string> $betas
     */
    public function withBetas(array $betas): self
    {
        $obj = clone $this;
        $obj->betas = $betas;

        return $obj;
    }
}
