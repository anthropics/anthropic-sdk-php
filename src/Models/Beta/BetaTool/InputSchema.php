<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaTool;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;

/**
 * [JSON schema](https://json-schema.org/draft/2020-12) for this tool's input.
 *
 * This defines the shape of the `input` that your tool accepts and that the model will produce.
 *
 * @phpstan-type input_schema_alias = array{
 *   type: string, properties?: mixed, required?: list<string>|null
 * }
 */
final class InputSchema implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'object';

    #[Api(optional: true)]
    public mixed $properties;

    /** @var null|list<string> $required */
    #[Api(type: new ListOf('string'), nullable: true, optional: true)]
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
        self::introspect();
        $this->unsetOptionalProperties();

        null !== $properties && $this->properties = $properties;
        null !== $required && $this->required = $required;
    }
}
