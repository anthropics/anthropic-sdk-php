<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaTool;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Models\Beta\BetaTool\InputSchema\Type;

final class InputSchema implements BaseModel
{
    use Model;

    /** @var Type::* $type */
    #[Api]
    public string $type;

    #[Api(optional: true)]
    public mixed $properties;

    /** @var null|list<string> $required */
    #[Api(type: new UnionOf([new ListOf('string'), 'null']), optional: true)]
    public ?array $required;

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::*           $type
     * @param null|list<string> $required
     */
    final public function __construct(
        string $type,
        mixed $properties = null,
        ?array $required = null
    ) {
        $this->type = $type;
        $this->properties = $properties;
        $this->required = $required;
    }
}

InputSchema::_loadMetadata();
