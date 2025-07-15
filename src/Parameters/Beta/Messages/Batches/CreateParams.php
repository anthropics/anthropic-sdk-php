<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Beta\Messages\Batches;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Parameters\Beta\Messages\Batches\CreateParams\Request;

class CreateParams implements BaseModel
{
    use Model;
    use Params;

    /** @var list<Request> $requests */
    #[Api(type: new ListOf(Request::class))]
    public array $requests;

    /** @var null|list<string|string> $anthropicBeta */
    #[Api(type: new ListOf(new UnionOf(['string', 'string'])), optional: true)]
    public ?array $anthropicBeta;
}

CreateParams::_loadMetadata();
