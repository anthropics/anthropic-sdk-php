<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
use Anthropic\Models\Beta\BetaTool\InputSchema;

final class BetaTool implements BaseModel
{
    use Model;

    #[Api('input_schema')]
    public InputSchema $inputSchema;

    #[Api]
    public string $name;

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    #[Api(optional: true)]
    public ?string $description;

    #[Api(optional: true)]
    public ?string $type;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param InputSchema               $inputSchema  `required`
     * @param string                    $name         `required`
     * @param BetaCacheControlEphemeral $cacheControl
     * @param null|string               $description
     * @param null|string               $type
     */
    final public function __construct(
        $inputSchema,
        $name,
        $cacheControl = None::NOT_GIVEN,
        $description = None::NOT_GIVEN,
        $type = None::NOT_GIVEN,
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaTool::_loadMetadata();
