<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * An object containing the method's parameters.
 * Example usage:
 * ```
 * $params = (new BatchResultsParams); // set properties as needed
 * $client->beta.messages.batches->results(...$params->toArray());
 * ```
 * Streams the results of a Message Batch as a `.jsonl` file.
 *
 * Each line in the file is a JSON object containing the result of a single request in the Message Batch. Results are not guaranteed to be in the same order as requests. Use the `custom_id` field to match results to requests.
 *
 * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
 *
 * @method toArray()
 *   Returns the parameters as an associative array suitable for passing to the client method.
 *
 *   `$client->beta.messages.batches->results(...$params->toArray());`
 *
 * @see Anthropic\Beta\Messages\Batches->results
 *
 * @phpstan-type batch_results_params = array{betas?: list<string|AnthropicBeta>}
 */
final class BatchResultsParams implements BaseModel
{
    /** @use SdkModel<batch_results_params> */
    use SdkModel;
    use SdkParams;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Api(list: AnthropicBeta::class, optional: true)]
    public ?array $betas;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string|AnthropicBeta> $betas
     */
    public static function with(?array $betas = null): self
    {
        $obj = new self;

        null !== $betas && $obj->betas = array_map(fn ($v) => $v instanceof AnthropicBeta ? $v->value : $v, $betas);

        return $obj;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta> $betas
     */
    public function withBetas(array $betas): self
    {
        $obj = clone $this;
        $obj->betas = array_map(fn ($v) => $v instanceof AnthropicBeta ? $v->value : $v, $betas);

        return $obj;
    }
}
