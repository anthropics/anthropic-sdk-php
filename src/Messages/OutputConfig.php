<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type JSONOutputFormatShape from \Anthropic\Messages\JSONOutputFormat
 *
 * @phpstan-type OutputConfigShape = array{
 *   format?: null|JSONOutputFormat|JSONOutputFormatShape
 * }
 */
final class OutputConfig implements BaseModel
{
    /** @use SdkModel<OutputConfigShape> */
    use SdkModel;

    /**
     * A schema to specify Claude's output format in responses. See [structured outputs](https://platform.claude.com/docs/en/build-with-claude/structured-outputs).
     */
    #[Optional(nullable: true)]
    public ?JSONOutputFormat $format;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param JSONOutputFormat|JSONOutputFormatShape|null $format
     */
    public static function with(
        JSONOutputFormat|array|null $format = null
    ): self {
        $self = new self;

        null !== $format && $self['format'] = $format;

        return $self;
    }

    /**
     * A schema to specify Claude's output format in responses. See [structured outputs](https://platform.claude.com/docs/en/build-with-claude/structured-outputs).
     *
     * @param JSONOutputFormat|JSONOutputFormatShape|null $format
     */
    public function withFormat(JSONOutputFormat|array|null $format): self
    {
        $self = clone $this;
        $self['format'] = $format;

        return $self;
    }
}
