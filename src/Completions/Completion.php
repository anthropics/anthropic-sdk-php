<?php

declare(strict_types=1);

namespace Anthropic\Completions;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Model;
use Anthropic\Messages\Model\UnionMember0;

/**
 * @phpstan-type completion_alias = array{
 *   id: string,
 *   completion: string,
 *   model: UnionMember0::*|string,
 *   stopReason: string|null,
 *   type: string,
 * }
 */
final class Completion implements BaseModel
{
    use ModelTrait;

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
     * @var string|UnionMember0::* $model
     */
    #[Api(union: Model::class)]
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
     * @param string|UnionMember0::* $model
     */
    public static function new(
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
    public function setID(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * The resulting completion up to and excluding the stop sequences.
     */
    public function setCompletion(string $completion): self
    {
        $this->completion = $completion;

        return $this;
    }

    /**
     * The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     *
     * @param string|UnionMember0::* $model
     */
    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * The reason that we stopped.
     *
     * This may be one the following values:
     * * `"stop_sequence"`: we reached a stop sequence — either provided by you via the `stop_sequences` parameter, or a stop sequence built into the model
     * * `"max_tokens"`: we exceeded `max_tokens_to_sample` or the model's maximum
     */
    public function setStopReason(?string $stopReason): self
    {
        $this->stopReason = $stopReason;

        return $this;
    }
}
