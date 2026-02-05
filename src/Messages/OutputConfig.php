<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\OutputConfig\Effort;

/**
 * @phpstan-import-type JSONOutputFormatShape from \Anthropic\Messages\JSONOutputFormat
 *
 * @phpstan-type OutputConfigShape = array{
 *   effort?: null|Effort|value-of<Effort>,
 *   format?: null|JSONOutputFormat|JSONOutputFormatShape,
 * }
 */
final class OutputConfig implements BaseModel
{
    /** @use SdkModel<OutputConfigShape> */
    use SdkModel;

    /**
     * All possible effort levels.
     *
     * @var value-of<Effort>|null $effort
     */
    #[Optional(enum: Effort::class, nullable: true)]
    public ?string $effort;

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
     * @param Effort|value-of<Effort>|null $effort
     * @param JSONOutputFormat|JSONOutputFormatShape|null $format
     */
    public static function with(
        Effort|string|null $effort = null,
        JSONOutputFormat|array|null $format = null,
    ): self {
        $self = new self;

        null !== $effort && $self['effort'] = $effort;
        null !== $format && $self['format'] = $format;

        return $self;
    }

    /**
     * All possible effort levels.
     *
     * @param Effort|value-of<Effort>|null $effort
     */
    public function withEffort(Effort|string|null $effort): self
    {
        $self = clone $this;
        $self['effort'] = $effort;

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
