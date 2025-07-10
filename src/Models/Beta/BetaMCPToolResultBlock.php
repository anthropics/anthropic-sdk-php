<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class BetaMCPToolResultBlock implements BaseModel
{
    use Model;

    /** @var list<BetaTextBlock>|string $content */
    #[Api(type: new UnionOf(['string', new ListOf(BetaTextBlock::class)]))]
    public mixed $content;

    #[Api('is_error')]
    public bool $isError;

    #[Api('tool_use_id')]
    public string $toolUseID;

    #[Api]
    public string $type;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param list<BetaTextBlock>|string $content   `required`
     * @param bool                       $isError   `required`
     * @param string                     $toolUseID `required`
     * @param string                     $type      `required`
     */
    final public function __construct($content, $isError, $toolUseID, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaMCPToolResultBlock::_loadMetadata();
