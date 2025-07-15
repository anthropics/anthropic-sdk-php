<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Completions;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Models\Metadata;

final class CreateParams implements BaseModel
{
    use Model;
    use Params;

    #[Api('max_tokens_to_sample')]
    public int $maxTokensToSample;

    #[Api]
    public string $model;

    #[Api]
    public string $prompt;

    #[Api(optional: true)]
    public ?Metadata $metadata;

    /** @var null|list<string> $stopSequences */
    #[Api('stop_sequences', type: new ListOf('string'), optional: true)]
    public ?array $stopSequences;

    #[Api(optional: true)]
    public ?bool $stream;

    #[Api(optional: true)]
    public ?float $temperature;

    #[Api('top_k', optional: true)]
    public ?int $topK;

    #[Api('top_p', optional: true)]
    public ?float $topP;

    /** @var null|list<string> $anthropicBeta */
    #[Api(type: new ListOf(new UnionOf(['string', 'string'])), optional: true)]
    public ?array $anthropicBeta;

    /**
     * You must use named parameters to construct this object.
     *
     * @param null|list<string> $stopSequences
     * @param null|list<string> $anthropicBeta
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
        $this->metadata = $metadata;
        $this->stopSequences = $stopSequences;
        $this->stream = $stream;
        $this->temperature = $temperature;
        $this->topK = $topK;
        $this->topP = $topP;
        $this->anthropicBeta = $anthropicBeta;
    }
}

CreateParams::_loadMetadata();
