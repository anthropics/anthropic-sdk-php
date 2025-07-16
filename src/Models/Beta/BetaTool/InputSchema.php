<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaTool;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

final class InputSchema implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'object';

    #[Api(optional: true)]
    public mixed $properties;

    /** @var null|list<string> $required */
    #[Api(type: new UnionOf([new ListOf('string'), 'null']), optional: true)]
    public ?array $required;

    /**
     * You must use named parameters to construct this object.
     *
     * @param null|list<string> $required
     */
    final public function __construct(
        mixed $properties = null,
        ?array $required = null
    ) {
        $this->properties = $properties;
        $this->required = $required;
    }
}

InputSchema::__introspect();
