<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * This endpoint is idempotent and can be used to poll for Message Batch completion. To access the results of a Message Batch, make a request to the `results_url` field in the response.
 *
 * Learn more about the Message Batches API in our [user guide](https://docs.claude.com/en/docs/build-with-claude/batch-processing)
 *
 * @see Anthropic\Services\Beta\Messages\BatchesService::retrieve()
 *
 * @phpstan-type BatchRetrieveParamsShape = array{
 *   betas?: list<string|AnthropicBeta>
 * }
 */
final class BatchRetrieveParams implements BaseModel
{
    /** @use SdkModel<BatchRetrieveParamsShape> */
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

        null !== $betas && $obj['betas'] = $betas;

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
        $obj['betas'] = $betas;

        return $obj;
    }
}
