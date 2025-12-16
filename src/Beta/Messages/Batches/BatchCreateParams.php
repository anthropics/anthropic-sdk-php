<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Messages\Batches\BatchCreateParams\Request;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Send a batch of Message creation requests.
 *
 * The Message Batches API can be used to process multiple Messages API requests at once. Once a Message Batch is created, it begins processing immediately. Batches can take up to 24 hours to complete.
 *
 * Learn more about the Message Batches API in our [user guide](https://docs.claude.com/en/docs/build-with-claude/batch-processing)
 *
 * @see Anthropic\Services\Beta\Messages\BatchesService::create()
 *
 * @phpstan-import-type RequestShape from \Anthropic\Beta\Messages\Batches\BatchCreateParams\Request
 *
 * @phpstan-type BatchCreateParamsShape = array{
 *   requests: list<RequestShape>,
 *   betas?: list<AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
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
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
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
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<RequestShape> $requests
     * @param list<AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public static function with(array $requests, ?array $betas = null): self
    {
        $self = new self;

        $self['requests'] = $requests;

        null !== $betas && $self['betas'] = $betas;

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

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
