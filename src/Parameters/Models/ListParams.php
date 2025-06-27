<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class ListParams implements BaseModel
{
    use Model;
    use Params;

    #[Api(optional: true)]
    public string $afterID;

    #[Api(optional: true)]
    public string $beforeID;

    #[Api(optional: true)]
    public int $limit;

    /**
     * @var list<string|string> $betas
     */
    #[Api(type: new ListOf(new UnionOf(['string', 'string'])), optional: true)]
    public array $betas;
}

ListParams::_loadMetadata();
