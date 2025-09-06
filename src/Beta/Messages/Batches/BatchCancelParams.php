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
 * $params = (new BatchCancelParams); // set properties as needed
 * $client->beta.messages.batches->cancel(...$params->toArray());
 * ```
 * Batches may be canceled any time before processing ends. Once cancellation is initiated, the batch enters a `canceling` state, at which time the system may complete any in-progress, non-interruptible requests before finalizing cancellation.
 *
 * The number of canceled requests is specified in `request_counts`. To determine which requests were canceled, check the individual results within the batch. Note that cancellation may not result in any canceled requests if they were non-interruptible.
 *
 * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
 *
 * @method toArray()
 *   Returns the parameters as an associative array suitable for passing to the client method.
 *
 *   `$client->beta.messages.batches->cancel(...$params->toArray());`
 *
 * @see Anthropic\Beta\Messages\Batches->cancel
 *
 * @phpstan-type batch_cancel_params = array{betas?: list<AnthropicBeta::*|string>}
 */
final class BatchCancelParams implements BaseModel
{
    /** @use SdkModel<batch_cancel_params> */
    use SdkModel;
    use SdkParams;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<AnthropicBeta::*|string>|null $betas
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
     * @param list<AnthropicBeta::*|string> $betas
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
