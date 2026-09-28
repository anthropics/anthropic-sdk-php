<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaSystemMessageOutputConfig\Effort;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Per-message output configuration on a role:"system" input message.
 *
 * Fields here apply per-turn; ``format`` remains top-level only. An
 * empty ``{}`` is accepted on a message that carries content; a message
 * with neither content nor output_config fields is rejected.
 *
 * @phpstan-type BetaSystemMessageOutputConfigShape = array{
 *   effort?: null|Effort|value-of<Effort>
 * }
 */
final class BetaSystemMessageOutputConfig implements BaseModel
{
    /** @use SdkModel<BetaSystemMessageOutputConfigShape> */
    use SdkModel;

    /**
     * How much effort the model should put into its response. Higher effort levels may result in more thorough analysis but take longer.
     *
     * Valid values are `low`, `medium`, `high`, `xhigh`, or `max`.
     *
     * @var value-of<Effort>|null $effort
     */
    #[Optional(enum: Effort::class, nullable: true)]
    public ?string $effort;

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
     */
    public static function with(Effort|string|null $effort = null): self
    {
        $self = new self;

        null !== $effort && $self['effort'] = $effort;

        return $self;
    }

    /**
     * How much effort the model should put into its response. Higher effort levels may result in more thorough analysis but take longer.
     *
     * Valid values are `low`, `medium`, `high`, `xhigh`, or `max`.
     *
     * @param Effort|value-of<Effort>|null $effort
     */
    public function withEffort(Effort|string|null $effort): self
    {
        $self = clone $this;
        $self['effort'] = $effort;

        return $self;
    }
}
