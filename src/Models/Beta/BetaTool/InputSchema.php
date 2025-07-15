<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaTool;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

final class InputSchema implements BaseModel
{
    use Model;

    #[Api]
    public string $type;

    /** @var null|mixed $properties */
    #[Api(optional: true)]
    public mixed $properties;

    /** @var null|list<string> $required */
    #[Api(type: new UnionOf([new ListOf('string'), 'null']), optional: true)]
    public ?array $required;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string            $type       `required`
     * @param null|mixed        $properties
     * @param null|list<string> $required
     */
    final public function __construct(
        $type,
        $properties = None::NOT_GIVEN,
        $required = None::NOT_GIVEN
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

InputSchema::_loadMetadata();
