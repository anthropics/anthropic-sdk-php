<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Beta\Messages\Batches;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class CancelParams implements BaseModel
{
    use Model;
    use Params;

    /**
     * @var list<string|string> $anthropicBeta
     */
    #[Api(type: new ListOf(new UnionOf(['string', 'string'])), optional: true)]
    public array $anthropicBeta;
}

CancelParams::_loadMetadata();
