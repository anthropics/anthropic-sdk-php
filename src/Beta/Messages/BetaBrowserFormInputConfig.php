<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * ``form_input``'s config overrides.
 *
 * @phpstan-type BetaBrowserFormInputConfigShape = array{
 *   deferLoading?: bool|null, enabled?: bool|null
 * }
 */
final class BetaBrowserFormInputConfig implements BaseModel
{
    /** @use SdkModel<BetaBrowserFormInputConfigShape> */
    use SdkModel;

    /**
     * Defer loading for this member. Must resolve to the same value on every enabled member of the toolset.
     */
    #[Optional('defer_loading', nullable: true)]
    public ?bool $deferLoading;

    /**
     * Whether this member is offered to the model. Default is per member, per the toolset's documentation. A member whose enabled resolves false is withheld from the served schema.
     */
    #[Optional(nullable: true)]
    public ?bool $enabled;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?bool $deferLoading = null,
        ?bool $enabled = null
    ): self {
        $self = new self;

        null !== $deferLoading && $self['deferLoading'] = $deferLoading;
        null !== $enabled && $self['enabled'] = $enabled;

        return $self;
    }

    /**
     * Defer loading for this member. Must resolve to the same value on every enabled member of the toolset.
     */
    public function withDeferLoading(?bool $deferLoading): self
    {
        $self = clone $this;
        $self['deferLoading'] = $deferLoading;

        return $self;
    }

    /**
     * Whether this member is offered to the model. Default is per member, per the toolset's documentation. A member whose enabled resolves false is withheld from the served schema.
     */
    public function withEnabled(?bool $enabled): self
    {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }
}
