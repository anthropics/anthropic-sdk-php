<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\AnthropicBeta\UnionMember1;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;

/**
 * This endpoint is idempotent and can be used to poll for Message Batch completion. To access the results of a Message Batch, make a request to the `results_url` field in the response.
 *
 * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
 *
 * @phpstan-type retrieve_params = array{
 *   anthropicBeta?: list<string|UnionMember1::*>
 * }
 */
final class BatchRetrieveParams implements BaseModel
{
    use Model;
    use Params;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var null|list<string|UnionMember1::*> $anthropicBeta
     */
    #[Api(type: new ListOf(union: AnthropicBeta::class), optional: true)]
    public ?array $anthropicBeta;

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
     * @param null|list<string|UnionMember1::*> $anthropicBeta
     */
    public static function new(?array $anthropicBeta = null): self
    {
        $obj = new self;

        null !== $anthropicBeta && $obj->anthropicBeta = $anthropicBeta;

        return $obj;
    }
}
