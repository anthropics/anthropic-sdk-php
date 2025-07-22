<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Model\UnionMember0;

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

    /**
     * You must use named parameters to construct this object.
     *
     * @param string|UnionMember0::* $model
     */
    final public function __construct(
        string $id,
        string $completion,
        string $model,
        ?string $stopReason
    ) {
        self::introspect();

        $this->id = $id;
        $this->completion = $completion;
        $this->model = $model;
        $this->stopReason = $stopReason;
    }
}
