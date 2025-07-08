<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Beta\Files;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class UploadParams implements BaseModel
{
    use Model;
    use Params;

    #[Api]
    public string $file;

    /**
     * @var list<string|string> $anthropicBeta
     */
    #[Api(type: new ListOf(new UnionOf(['string', 'string'])), optional: true)]
    public array $anthropicBeta;
}

UploadParams::_loadMetadata();
