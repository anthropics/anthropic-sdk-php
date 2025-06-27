<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Completions;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Models\Metadata;

class CreateParams implements BaseModel
{
    use Model;
    use Params;

    #[Api('max_tokens_to_sample')]
    public int $maxTokensToSample;

    /**
     * @var string|string $model
     */
    #[Api]
    public mixed $model;

    #[Api]
    public string $prompt;

    #[Api(optional: true)]
    public Metadata $metadata;

    /**
     * @var list<string> $stopSequences
     */
    #[Api('stop_sequences', type: new ListOf('string'), optional: true)]
    public array $stopSequences;

    #[Api(optional: true)]
    public bool $stream;

    #[Api(optional: true)]
    public float $temperature;

    #[Api('top_k', optional: true)]
    public int $topK;

    #[Api('top_p', optional: true)]
    public float $topP;

    /**
     * @var list<string|string> $betas
     */
    #[Api(type: new ListOf(new UnionOf(['string', 'string'])), optional: true)]
    public array $betas;
}

CreateParams::_loadMetadata();
