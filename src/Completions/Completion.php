<?php

declare(strict_types=1);

namespace Anthropic\Completions;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\UnionOf;
use Anthropic\Messages\Model as Model1;

/**
 * @phpstan-type completion_alias = array{
 *   id: string,
 *   completion: string,
 *   model: Model1::*|string,
 *   stopReason: string|null,
 *   type: string,
 * }
 */
final class Completion implements BaseModel
{
    use Model;

    /**
     * Object type.
     *
     * For Text Completions, this is always `"completion"`.
     */
    #[Api]
    public string $type = 'completion';

    /**
     * Unique object identifier.
     *
     * The format and length of IDs may change over time.
     */
    #[Api]
    public string $id;

    /**
     * The resulting completion up to and excluding the stop sequences.
     */
    #[Api]
    public string $completion;

    /**
     * The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     *
     * @var Model1::*|string $model
     */
    #[Api(union: new UnionOf([Model1::class, 'string']))]
    public string $model;

    /**
     * The reason that we stopped.
     *
     * This may be one the following values:
     * * `"stop_sequence"`: we reached a stop sequence — either provided by you via the `stop_sequences` parameter, or a stop sequence built into the model
     * * `"max_tokens"`: we exceeded `max_tokens_to_sample` or the model's maximum
     */
    #[Api('stop_reason')]
    public ?string $stopReason;

    /**
     * `new Completion()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Completion::with(id: ..., completion: ..., model: ..., stopReason: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Completion)
     *   ->withID(...)
     *   ->withCompletion(...)
     *   ->withModel(...)
     *   ->withStopReason(...)
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
     * @param Model1::*|string $model
     */
    public static function with(
        string $id,
        string $completion,
        string $model,
        ?string $stopReason
    ): self {
        $obj = new self;

        $obj->id = $id;
        $obj->completion = $completion;
        $obj->model = $model;
        $obj->stopReason = $stopReason;

        return $obj;
    }

    /**
     * Unique object identifier.
     *
     * The format and length of IDs may change over time.
     */
    public function withID(string $id): self
    {
        $obj = clone $this;
        $obj->id = $id;

        return $obj;
    }

    /**
     * The resulting completion up to and excluding the stop sequences.
     */
    public function withCompletion(string $completion): self
    {
        $obj = clone $this;
        $obj->completion = $completion;

        return $obj;
    }

    /**
     * The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     *
     * @param Model1::*|string $model
     */
    public function withModel(string $model): self
    {
        $obj = clone $this;
        $obj->model = $model;

        return $obj;
    }

    /**
     * The reason that we stopped.
     *
     * This may be one the following values:
     * * `"stop_sequence"`: we reached a stop sequence — either provided by you via the `stop_sequences` parameter, or a stop sequence built into the model
     * * `"max_tokens"`: we exceeded `max_tokens_to_sample` or the model's maximum
     */
    public function withStopReason(?string $stopReason): self
    {
        $obj = clone $this;
        $obj->stopReason = $stopReason;

        return $obj;
    }
}
