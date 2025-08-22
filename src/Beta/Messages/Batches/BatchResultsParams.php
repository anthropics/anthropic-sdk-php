<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Core\Conversion\UnionOf;

/**
 * Streams the results of a Message Batch as a `.jsonl` file.
 *
 * Each line in the file is a JSON object containing the result of a single request in the Message Batch. Results are not guaranteed to be in the same order as requests. Use the `custom_id` field to match results to requests.
 *
 * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
 */
final class BatchResultsParams implements BaseModel
{
    use SdkModel;
    use SdkParams;

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
     * @param list<AnthropicBeta::*|string>|null $betas
     */
    public static function with(?array $betas = null): self
    {
        $obj = new self;

        null !== $betas && $obj->betas = $betas;

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
