<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

final class RetrieveParams implements BaseModel
{
    use Model;
    use Params;

    /** @var null|list<string|string> $anthropicBeta */
    #[Api(type: new ListOf(new UnionOf(['string', 'string'])), optional: true)]
    public ?array $anthropicBeta;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param null|list<string|string> $anthropicBeta
     */
    final public function __construct($anthropicBeta = None::NOT_GIVEN)
    {
        $this->constructFromArgs(func_get_args());
    }
}

RetrieveParams::_loadMetadata();
