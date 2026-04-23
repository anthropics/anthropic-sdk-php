<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * User-configurable total token budget across contexts.
 *
 * @phpstan-type BetaTokenTaskBudgetShape = array{
 *   total: int, type: 'tokens', remaining?: int|null
 * }
 */
final class BetaTokenTaskBudget implements BaseModel
{
    /** @use SdkModel<BetaTokenTaskBudgetShape> */
    use SdkModel;

    /**
     * The budget type. Currently only 'tokens' is supported.
     *
     * @var 'tokens' $type
     */
    #[Required]
    public string $type = 'tokens';

    /**
     * Total token budget across all contexts in the session.
     */
    #[Required]
    public int $total;

    /**
     * Remaining tokens in the budget. Use this to track usage across contexts when implementing compaction client-side. Defaults to total if not provided.
     */
    #[Optional(nullable: true)]
    public ?int $remaining;

    /**
     * `new BetaTokenTaskBudget()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTokenTaskBudget::with(total: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaTokenTaskBudget)->withTotal(...)
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
     */
    public static function with(int $total, ?int $remaining = null): self
    {
        $self = new self;

        $self['total'] = $total;

        null !== $remaining && $self['remaining'] = $remaining;

        return $self;
    }

    /**
     * Total token budget across all contexts in the session.
     */
    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }

    /**
     * The budget type. Currently only 'tokens' is supported.
     *
     * @param 'tokens' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Remaining tokens in the budget. Use this to track usage across contexts when implementing compaction client-side. Defaults to total if not provided.
     */
    public function withRemaining(?int $remaining): self
    {
        $self = clone $this;
        $self['remaining'] = $remaining;

        return $self;
    }
}
