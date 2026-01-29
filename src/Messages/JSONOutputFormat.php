<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type JSONOutputFormatShape = array{
 *   schema: array<string,mixed>, type: 'json_schema'
 * }
 */
final class JSONOutputFormat implements BaseModel
{
    /** @use SdkModel<JSONOutputFormatShape> */
    use SdkModel;

    /** @var 'json_schema' $type */
    #[Required]
    public string $type = 'json_schema';

    /**
     * The JSON schema of the format.
     *
     * @var array<string,mixed> $schema
     */
    #[Required(map: 'mixed')]
    public array $schema;

    /**
     * `new JSONOutputFormat()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * JSONOutputFormat::with(schema: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new JSONOutputFormat)->withSchema(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,mixed> $schema
     */
    public static function with(array $schema): self
    {
        $self = new self;

        $self['schema'] = $schema;

        return $self;
    }

    /**
     * The JSON schema of the format.
     *
     * @param array<string,mixed> $schema
     */
    public function withSchema(array $schema): self
    {
        $self = clone $this;
        $self['schema'] = $schema;

        return $self;
    }
}
