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

final class UploadParams implements BaseModel
{
    use Model;
    use Params;

    #[Api]
    public string $file;

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
    final public function __construct(string $file, ?array $anthropicBeta = null)
    {
        $this->file = $file;
        $this->anthropicBeta = $anthropicBeta;
    }
}

UploadParams::_loadMetadata();
