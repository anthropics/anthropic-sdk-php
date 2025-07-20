<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Models\AnthropicBeta;
use Anthropic\Models\AnthropicBeta\UnionMember1;
use Anthropic\Parameters\Beta\Messages\BatchCreateParam\Request;

/**
 * @phpstan-type create_params = array{
 *   requests: list<Request>, anthropicBeta?: list<string|UnionMember1::*>
 * }
 */
final class BatchCreateParam implements BaseModel
{
    use Model;
    use Params;

    /** @var list<Request> $requests */
    #[Api(type: new ListOf(Request::class))]
    public array $requests;

    /** @var null|list<string|UnionMember1::*> $anthropicBeta */
    #[Api(type: new ListOf(union: AnthropicBeta::class), optional: true)]
    public ?array $anthropicBeta;

    /**
     * You must use named parameters to construct this object.
     *
     * @param list<Request>                     $requests
     * @param null|list<string|UnionMember1::*> $anthropicBeta
     */
    final public function __construct(
        array $requests,
        ?array $anthropicBeta = null
    ) {
        self::introspect();
        $this->unsetOptionalProperties();

        $this->requests = $requests;

        null !== $anthropicBeta && $this->anthropicBeta = $anthropicBeta;
    }
}
