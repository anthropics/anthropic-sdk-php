<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaOutputConfig\Effort;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaOutputConfigShape = array{effort?: value-of<Effort>|null}
 */
final class BetaOutputConfig implements BaseModel
{
    /** @use SdkModel<BetaOutputConfigShape> */
    use SdkModel;

    /**
     * All possible effort levels.
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
        $obj = new self;

        null !== $effort && $obj['effort'] = $effort;

        return $obj;
    }

    /**
     * All possible effort levels.
     *
     * @param Effort|value-of<Effort>|null $effort
     */
    public function withEffort(Effort|string|null $effort): self
    {
        $obj = clone $this;
        $obj['effort'] = $effort;

        return $obj;
    }
}
