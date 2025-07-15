<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

final class BetaRequestMCPServerToolConfiguration implements BaseModel
{
    use Model;

    /** @var null|list<string> $allowedTools */
    #[Api(
        'allowed_tools',
        type: new UnionOf([new ListOf('string'), 'null']),
        optional: true,
    )]
    public ?array $allowedTools;

    #[Api(optional: true)]
    public ?bool $enabled;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param null|list<string> $allowedTools
     * @param null|bool         $enabled
     */
    final public function __construct(
        $allowedTools = None::NOT_GIVEN,
        $enabled = None::NOT_GIVEN
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaRequestMCPServerToolConfiguration::_loadMetadata();
