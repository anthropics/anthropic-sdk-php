<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Beta\Files;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

final class RetrieveMetadataParams implements BaseModel
{
    use Model;
    use Params;

    /** @var null|list<string> $anthropicBeta */
    #[Api(type: new ListOf(new UnionOf(['string', 'string'])), optional: true)]
    public ?array $anthropicBeta;

    /**
     * You must use named parameters to construct this object.
     *
     * @param null|list<string> $anthropicBeta
     */
    final public function __construct(?array $anthropicBeta = null)
    {
        $this->anthropicBeta = $anthropicBeta;
    }
}

RetrieveMetadataParams::_loadMetadata();
