<?php

declare(strict_types=1);

namespace Anthropic\Beta\Models;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * An object containing the method's parameters.
 * Example usage:
 * ```
 * $params = (new ModelRetrieveParams); // set properties as needed
 * $client->beta.models->retrieve(...$params->toArray());
 * ```
 * Get a specific model.
 *
 * The Models API response can be used to determine information about a specific model or resolve a model alias to a model ID.
 *
 * @method toArray()
 *   Returns the parameters as an associative array suitable for passing to the client method.
 *
 *   `$client->beta.models->retrieve(...$params->toArray());`
 *
 * @see Anthropic\Beta\Models->retrieve
 *
 * @phpstan-type model_retrieve_params = array{
 *   betas?: list<AnthropicBeta::*|string>
 * }
 */
final class ModelRetrieveParams implements BaseModel
{
    /** @use SdkModel<model_retrieve_params> */
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
