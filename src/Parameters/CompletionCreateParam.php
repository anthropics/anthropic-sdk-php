<?php

declare(strict_types=1);

namespace Anthropic\Parameters;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Models\AnthropicBeta\UnionMember1;
use Anthropic\Models\Metadata;
use Anthropic\Models\Model\UnionMember0;
use Anthropic\Parameters\CompletionCreateParam\Stream;

final class CompletionCreateParam implements BaseModel
{
    use Model;
    use Params;

    #[Api('max_tokens_to_sample')]
    public int $maxTokensToSample;

    /** @var string|UnionMember0::* $model */
    #[Api]
    public string $model;

    #[Api]
    public string $prompt;

    #[Api(optional: true)]
    public ?Metadata $metadata;

    /** @var null|list<string> $stopSequences */
    #[Api('stop_sequences', type: new ListOf('string'), optional: true)]
    public ?array $stopSequences;

    /** @var null|Stream::* $stream */
    #[Api(optional: true)]
    public ?bool $stream;

    #[Api(optional: true)]
    public ?float $temperature;

    #[Api('top_k', optional: true)]
    public ?int $topK;

    #[Api('top_p', optional: true)]
    public ?float $topP;

    /** @var null|list<string|UnionMember1::*> $anthropicBeta */
    #[Api(
        type: new ListOf(new UnionOf(['string', UnionMember1::class])),
        optional: true,
    )]
    public ?array $anthropicBeta;

    /**
     * You must use named parameters to construct this object.
     *
     * @param string|UnionMember0::*            $model
     * @param null|list<string>                 $stopSequences
     * @param null|Stream::*                    $stream
     * @param null|list<string|UnionMember1::*> $anthropicBeta
     */
    final public function __construct(
        int $maxTokensToSample,
        string $model,
        string $prompt,
        ?bool $stream,
        ?Metadata $metadata = null,
        ?array $stopSequences = null,
        ?float $temperature = null,
        ?int $topK = null,
        ?float $topP = null,
        ?array $anthropicBeta = null,
    ) {
        $this->maxTokensToSample = $maxTokensToSample;
        $this->model = $model;
        $this->prompt = $prompt;

        self::_introspect();
        $this->unsetOptionalProperties();

        null != $metadata && $this->metadata = $metadata;
        null != $stopSequences && $this->stopSequences = $stopSequences;
        null != $stream && $this->stream = $stream;
        null != $temperature && $this->temperature = $temperature;
        null != $topK && $this->topK = $topK;
        null != $topP && $this->topP = $topP;
        null != $anthropicBeta && $this->anthropicBeta = $anthropicBeta;
    }
}
