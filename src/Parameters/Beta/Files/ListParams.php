<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Beta\Files;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Models\AnthropicBeta\UnionMember1;

final class ListParams implements BaseModel
{
    use Model;
    use Params;

    #[Api(optional: true)]
    public ?string $afterID;

    #[Api(optional: true)]
    public ?string $beforeID;

    #[Api(optional: true)]
    public ?int $limit = 20;

    /** @var null|list<string|UnionMember1::*> $anthropicBeta */
    #[Api(
        type: new ListOf(new UnionOf(['string', UnionMember1::class])),
        optional: true,
    )]
    public ?array $anthropicBeta;

    /**
     * You must use named parameters to construct this object.
     *
     * @param null|list<string|UnionMember1::*> $anthropicBeta
     */
    final public function __construct(
        ?string $afterID = null,
        ?string $beforeID = null,
        ?int $limit = null,
        ?array $anthropicBeta = null,
    ) {
        $this->afterID = $afterID;
        $this->beforeID = $beforeID;
        $this->limit = $limit;
        $this->anthropicBeta = $anthropicBeta;
    }
}

ListParams::__introspect();
