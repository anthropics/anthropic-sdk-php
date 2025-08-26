<?php

declare(strict_types=1);

namespace Anthropic\Messages\Tool;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * [JSON schema](https://json-schema.org/draft/2020-12) for this tool's input.
 *
 * This defines the shape of the `input` that your tool accepts and that the model will produce.
 */
final class InputSchema implements BaseModel
{
    use SdkModel;

    #[Api]
    public string $type = 'object';

    #[Api(nullable: true, optional: true)]
    public mixed $properties;

    /** @var list<string>|null $required */
    #[Api(list: 'string', nullable: true, optional: true)]
    public ?array $required;

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $required
     */
    public static function with(
        mixed $properties = null,
        ?array $required = null
    ): self {
        $obj = new self;

        null !== $properties && $obj->properties = $properties;
        null !== $required && $obj->required = $required;

        return $obj;
    }

    public function withProperties(mixed $properties): self
    {
        $obj = clone $this;
        $obj->properties = $properties;

        return $obj;
    }

    /**
     * @param list<string>|null $required
     */
    public function withRequired(?array $required): self
    {
        $obj = clone $this;
        $obj->required = $required;

        return $obj;
    }
}
