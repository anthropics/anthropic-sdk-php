<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaOutputConfig\Effort;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaJSONOutputFormatShape from \Anthropic\Beta\Messages\BetaJSONOutputFormat
 *
 * @phpstan-type BetaOutputConfigShape = array{
 *   effort?: null|Effort|value-of<Effort>,
 *   format?: null|BetaJSONOutputFormat|BetaJSONOutputFormatShape,
 * }
 */
final class BetaOutputConfig implements BaseModel
{
    /** @use SdkModel<BetaOutputConfigShape> */
    use SdkModel;

    /**
     * How much effort the model should put into its response. Higher effort levels may result in more thorough analysis but take longer.
     *
     * Valid values are `low`, `medium`, or `high`.
     *
     * @var value-of<Effort>|null $effort
     */
    #[Optional(enum: Effort::class, nullable: true)]
    public ?string $effort;

    /**
     * A schema to specify Claude's output format in responses. See [structured outputs](https://platform.claude.com/docs/en/build-with-claude/structured-outputs).
     */
    #[Optional(nullable: true)]
    public ?BetaJSONOutputFormat $format;

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
     * @param BetaJSONOutputFormat|BetaJSONOutputFormatShape|null $format
     */
    public static function with(
        Effort|string|null $effort = null,
        BetaJSONOutputFormat|array|null $format = null,
    ): self {
        $self = new self;

        null !== $effort && $self['effort'] = $effort;
        null !== $format && $self['format'] = $format;

        return $self;
    }

    /**
     * How much effort the model should put into its response. Higher effort levels may result in more thorough analysis but take longer.
     *
     * Valid values are `low`, `medium`, or `high`.
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
     * @param BetaJSONOutputFormat|BetaJSONOutputFormatShape|null $format
     */
    public function withFormat(BetaJSONOutputFormat|array|null $format): self
    {
        $self = clone $this;
        $self['format'] = $format;

        return $self;
    }
}
