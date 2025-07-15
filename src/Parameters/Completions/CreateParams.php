<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Completions;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Models\Metadata;

final class CreateParams implements BaseModel
{
    use Model;
    use Params;

    #[Api('max_tokens_to_sample')]
    public int $maxTokensToSample;

    /** @var string|string $model */
    #[Api]
    public mixed $model;

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

    /** @var null|list<string|string> $anthropicBeta */
    #[Api(type: new ListOf(new UnionOf(['string', 'string'])), optional: true)]
    public ?array $anthropicBeta;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param int                      $maxTokensToSample `required`
     * @param string|string            $model             `required`
     * @param string                   $prompt            `required`
     * @param Metadata                 $metadata
     * @param null|list<string>        $stopSequences
     * @param null|bool                $stream            `required`
     * @param null|float               $temperature
     * @param null|int                 $topK
     * @param null|float               $topP
     * @param null|list<string|string> $anthropicBeta
     */
    final public function __construct(
        $maxTokensToSample,
        $model,
        $prompt,
        $stream,
        $metadata = None::NOT_GIVEN,
        $stopSequences = None::NOT_GIVEN,
        $temperature = None::NOT_GIVEN,
        $topK = None::NOT_GIVEN,
        $topP = None::NOT_GIVEN,
        $anthropicBeta = None::NOT_GIVEN,
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

CreateParams::_loadMetadata();
